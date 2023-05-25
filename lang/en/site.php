<?php

return [
    'notifications' => [
        'customer' => [
            'user' => [
                'register' => [
                    'title' => 'Welcome customer title',
                    'body' => 'Welcome customer body',
                ],
                'login' => [
                    'title' => 'Welcome customer title',
                    'body' => 'Welcome customer body',
                ],
                'verify_email' => [
                    'title' => 'Verify email title',
                    'body' => 'Verify email body',
                ],
            ],
            'wallet' => [
                'title' => 'Order Status',
                'changes' => [
                    'body' => 'New changes in your wallet',
                ],
            ],
            'order' => [
                'title' => 'Order Status',
                'to_processing' => [
                    'body' => 'Your Order has been approved',
                ],
                'to_shipment' => [
                    'body' => 'Your Order has been shipment'
                ],
                'to_pending' => [
                    'body' => 'Your Order has been pending'
                ],
                'to_delivered' => [
                    'body' => 'Your Order has been delivered'
                ],
                'to_cancel' => [
                    'body' => 'Your Order has been delivered'
                ],
            ]
        ],
        'courier' => [
            'order' => [
                'title' => 'Order Status',
                'to_shipment' => [
                    'body' => 'Your Order has been approved'
                ]
            ]
        ],
    ],
    'check_phone' => 'Check phone',
    'check_password' => 'Check password',
    'account_is_not_available_now' => 'Account is not available now',
];
