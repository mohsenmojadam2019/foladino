<?php

return [
    'payment' => [
        'driver' => env('PAYMENT_DRIVER', 'mock'),
    ],
    'zarinpal' => [
        'merchant_id' => env('ZARINPAL_MERCHANT_ID'),
        'api_base' => env('ZARINPAL_API_BASE', 'https://api.zarinpal.com'),
        'start_pay_base' => env('ZARINPAL_START_PAY_BASE', 'https://www.zarinpal.com/pg/StartPay'),
    ],
];
