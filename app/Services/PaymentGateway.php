<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Payment;

class PaymentGateway
{
    public function request(PurchaseOrder $order): array
    {
        $invoice = (new Invoice)->amount((int) $order->total_toman * 10);
        $payment = new Payment(config('payment'));
        $payment->callbackUrl(route('payment.callback', ['token' => $order->public_token]))
            ->purchase($invoice, function ($driver, $transactionId) use ($order) {
                $order->update(['authority' => (string) $transactionId]);
            });

        return ['authority' => (string) $invoice->getTransactionId(), 'url' => $payment->pay()->render()];
    }

    public function verify(PurchaseOrder $order, string $authority): array
    {
        try {
            $receipt = (new Payment(config('payment')))
                ->via(config('payment.default'))
                ->amount((int) $order->total_toman * 10)
                ->transactionId($authority)
                ->verify();
            return ['ok' => true, 'ref_id' => (string) $receipt->getReferenceId()];
        } catch (InvalidPaymentException) {
            return ['ok' => false, 'ref_id' => null];
        }
    }
}
