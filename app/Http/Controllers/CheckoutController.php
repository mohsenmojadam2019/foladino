<?php
namespace App\Http\Controllers;

use App\Models\{Product, PurchaseOrder};
use App\Services\PaymentGateway;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Services\ShippingCalculator;
use Throwable;

class CheckoutController extends Controller
{
    public function start(Request $request, PaymentGateway $gateway, ShippingCalculator $shipping): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'mobile' => ['required','string','max:20'],
            'city' => 'required|string|max:100',
            'delivery_address' => 'required|string|max:1000',
            'invoice_type' => 'required|in:personal,official',
            'deposit_percent' => 'required|integer|in:30,50,100',
        ]);
        $cart = $request->session()->get('cart', []);
        if (!$cart && $request->filled('product_id')) {
            $cart = [(int) $request->input('product_id') => (float) $request->input('amount', 0)];
        }
        abort_if(!$cart, 422, 'سبد خرید خالی است.');
        $products = Product::with('factory')->whereIn('id', array_keys($cart))->where('is_active', true)->get()->keyBy('id');
        abort_if($products->count() !== count($cart), 422, 'یکی از محصولات دیگر موجود نیست.');

        $subtotal = 0; $weight = 0; $first = $products->first();
        foreach ($cart as $productId => $quantity) {
            $product = $products->get($productId);
            abort_if($product->stock_status === 'unavailable' || $quantity < .01, 422, 'محصول انتخاب‌شده قابل سفارش نیست.');
            $subtotal += (int) round((float) $quantity * 1000 * (int) $product->price);
            $weight += (int) round((float) $quantity * 1000);
        }
        $shippingQuote = $shipping->calculate($data['city'], $weight, $first->factory);
        $totalToman = $subtotal + $shippingQuote['amount'];
        $order = DB::transaction(function () use ($data, $cart, $products, $subtotal, $weight, $shippingQuote, $totalToman) {
            $order = PurchaseOrder::create([
                'public_token' => (string) Str::uuid(), 'order_number' => 'FD-'.now()->format('ymd').'-'.str()->upper(Str::random(6)),
                'product_id' => $products->first()->id, 'customer_name' => $data['name'], 'mobile' => $data['mobile'], 'city' => $data['city'],
                'delivery_address' => $data['delivery_address'], 'invoice_type' => $data['invoice_type'], 'deposit_percent' => $data['deposit_percent'],
                'quantity_tons' => array_sum($cart), 'unit_price_toman' => $products->first()->price, 'subtotal_toman' => $subtotal,
                'shipping_toman' => $shippingQuote['amount'], 'total_weight_kg' => $weight, 'total_toman' => $totalToman,
                'status' => 'pending', 'gateway' => (string) config('payment.default', 'zarinpal'),
            ]);
            foreach ($cart as $productId => $quantity) {
                $product = $products->get($productId);
                $line = (int) round((float) $quantity * 1000 * (int) $product->price);
                $order->items()->create(['product_id'=>$product->id,'product_name'=>$product->name,'sku'=>$product->sku,'quantity_tons'=>$quantity,'unit_price_toman'=>$product->price,'line_total_toman'=>$line,'weight_kg'=>(int) round($quantity*1000)]);
            }
            return $order;
        });
        $request->session()->forget('cart');
        try {
            $payment = $gateway->request($order);
            $order->update([
                'status' => 'payment_started',
                'authority' => $payment['authority'],
            ]);

            return redirect()->away($payment['url']);
        } catch (Throwable $e) {
            report($e);
            $order->update(['status' => 'failed']);

            return back()
                ->withInput()
                ->with('error', 'درگاه پرداخت در دسترس نیست: '.$e->getMessage());
        }
    }

    public function callback(Request $request, string $token, PaymentGateway $gateway): View
    {
        $order = PurchaseOrder::with('product')->where('public_token', $token)->firstOrFail();
        if ($order->status === 'paid') {
            return view('payment-result', ['order' => $order, 'success' => true]);
        }

        $status = strtoupper((string) $request->query('Status'));
        $authority = (string) $request->query('Authority', $order->authority);

        if ($status !== 'OK' || $authority === '') {
            $order->update(['status' => 'cancelled']);
            return view('payment-result', ['order' => $order, 'success' => false]);
        }

        try {
            $verified = $gateway->verify($order, $authority);
        } catch (Throwable $e) {
            report($e);
            $order->update(['status' => 'failed']);
            return view('payment-result', ['order' => $order, 'success' => false]);
        }

        if (!$verified['ok']) {
            $order->update(['status' => 'failed']);
            return view('payment-result', ['order' => $order, 'success' => false]);
        }
        $order->update([
            'status' => 'paid',
            'authority' => $authority,
            'reference_id' => $verified['ref_id'] ?? null,
            'paid_at' => now(),
        ]);

        return view('payment-result', [
            'order' => $order->fresh('product'),
            'success' => true,
        ]);
    }

    public function invoice(string $token): View
    {
        $order = PurchaseOrder::with(['product.factory'])->where('public_token', $token)->firstOrFail();
        abort_unless($order->status === 'paid', 403, 'فاکتور فقط برای سفارش پرداخت‌شده قابل مشاهده است.');
        return view('invoice', compact('order'));
    }
}
