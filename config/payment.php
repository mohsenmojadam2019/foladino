<?php

return [
    'default' => env('PAYMENT_GATEWAY', 'zarinpal'),
    'drivers' => [
        'zarinpal' => [
            'apiPurchaseUrl' => env('ZARINPAL_API_PURCHASE_URL', 'https://api.zarinpal.com/pg/v4/payment/request.json'),
            'apiPaymentUrl' => env('ZARINPAL_API_PAYMENT_URL', 'https://www.zarinpal.com/pg/StartPay/'),
            'apiVerificationUrl' => env('ZARINPAL_API_VERIFY_URL', 'https://api.zarinpal.com/pg/v4/payment/verify.json'),
            'merchantId' => env('ZARINPAL_MERCHANT_ID'),
            'callbackUrl' => env('APP_URL').'/payment/callback',
            'description' => 'خرید محصولات فولادینو',
            'currency' => 'T',
            'mode' => env('ZARINPAL_MODE', 'normal'),
        ],
        'local' => [],
    ],
    'map' => [
        'zarinpal' => Shetabit\Multipay\Drivers\Zarinpal\Zarinpal::class,
        'local' => Shetabit\Multipay\Drivers\Local\Local::class,
    ],
];
