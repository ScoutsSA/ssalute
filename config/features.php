<?php

return [
    'aam' => [
        'check-user-existence' => [
            'enabled' => env('FEATURE_CHECK_USER_EXISTENCE', true),
        ],
        'aam_form' => [
            'enabled' => env('FEATURE_AAM_FORM', true),
        ],
        'aam_national_email_support' => env('FEATURE_AAM_SUPPORT_EMAIL', 'aam@scouts.org.za'),
    ],

    'local' => [
        'seeders' => [
            'enabled' => env('LOCAL_SEEDERS_ENABLED', false),
        ],
    ],
];
