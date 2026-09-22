<?php
namespace App\Http\Controllers;

use App\Models\{Product, PurchaseOrder};
use App\Services\PaymentGateway;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function start(Request $request, PaymentGateway $gateway): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:120',
            'mobile' => ['required','string','max:20'],
            'city' => 'nullable|string|max:100',
            'amount' => 'required|numeric|min:1|max:10000',
        ]);
        $product = Product::whereKey($data['product_id'])
            ->where('is_active', true)
            ->where('stock_status', '!=', 'unavailable')
            ->firstOrFail();

        $quantity = (float) $data['amount'];
        $unitPrice = (int) $product->price;
        $totalToman = (int) round($quantity * 1000 * $unitPrice);

        $order = PurchaseOrder::create([
            'public_token' => (string) Str::uuid(),
            'product_id' => $product->id,
            'customer_name' => $data['name'],
            'mobile' => $data['mobile'],
            'city' => $data['city'] ?? null,
            'quantity_tons' => $quantity,
            'unit_price_toman' => $unitPrice,
            'total_toman' => $totalToman,
            'status' => 'pending',
            'gateway' => (string) config('services.payment.driver', 'mock'),
        ]);
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
