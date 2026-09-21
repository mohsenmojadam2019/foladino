<?php
namespace App\Services;

use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaymentGateway
{
    public function request(PurchaseOrder $order): array
    {
        if ($this->isMock()) {
            $authority = 'MOCK-'.$order->public_token;
            return [
                'authority' => $authority,
                'url' => route('payment.callback', [
                    'token' => $order->public_token,
                    'Authority' => $authority,
                    'Status' => 'OK',
                ]),
                'payload' => ['mode' => 'mock'],
            ];
        }

        $merchantId = (string) config('services.zarinpal.merchant_id');
        if ($merchantId === '') {
            throw new RuntimeException('شناسه پذیرنده زرین‌پال تنظیم نشده است.');
        }
        $payload = [
            'merchant_id' => $merchantId,
            'amount' => $this->rialAmount($order),
            'callback_url' => route('payment.callback', ['token' => $order->public_token]),
            'description' => 'پرداخت سفارش فولادینو #'.$order->id,
            'metadata' => ['mobile' => $order->mobile],
        ];

        $response = Http::asJson()
            ->timeout(20)
            ->post(rtrim((string) config('services.zarinpal.api_base'), '/').'/pg/v4/payment/request.json', $payload)
            ->throw()
            ->json();

        $code = data_get($response, 'data.code');
        $authority = data_get($response, 'data.authority');
        if ((int) $code !== 100 || !$authority) {
            $message = data_get($response, 'errors.message', 'خطا در ایجاد تراکنش بانکی.');
            throw new RuntimeException((string) $message);
        }

        return [
            'authority' => (string) $authority,
            'url' => rtrim((string) config('services.zarinpal.start_pay_base'), '/').'/'.$authority,
            'payload' => $response,
        ];
    }
    public function verify(PurchaseOrder $order, string $authority): array
    {
        if ($this->isMock()) {
            return ['ok' => true, 'code' => 100, 'ref_id' => 'MOCK-'.$order->id, 'payload' => ['mode' => 'mock']];
        }

        $response = Http::asJson()
            ->timeout(20)
            ->post(rtrim((string) config('services.zarinpal.api_base'), '/').'/pg/v4/payment/verify.json', [
                'merchant_id' => (string) config('services.zarinpal.merchant_id'),
                'amount' => $this->rialAmount($order),
                'authority' => $authority,
            ])->throw()->json();

        $code = (int) data_get($response, 'data.code', 0);
        return [
            'ok' => in_array($code, [100, 101], true),
            'code' => $code,
            'ref_id' => data_get($response, 'data.ref_id'),
            'payload' => $response,
        ];
    }

    private function rialAmount(PurchaseOrder $order): int
    {
        return (int) $order->total_toman * 10;
    }

    private function isMock(): bool
    {
        return (string) config('services.payment.driver', 'mock') === 'mock';
    }
}
