<?php

return [
    'aam' => [
        'check-user-existence' => [
            'enabled' => env('FEATURE_CHECK_USER_EXISTENCE', true),
        ],
        'aam_form' => [
            'enabled' => env('FEATURE_AAM_FORM', true),
        ],
    ],
];
