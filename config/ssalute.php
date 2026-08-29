<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Super User
    |--------------------------------------------------------------------------
    |
    | This will be used as the default superuser email address
    | This user will be granted more superuser privileges
    | Mainly they can always access the backoffice
    |
    */

    'superuser_email' => env('SSALUTE_SUPERUSER_EMAIL'),
    'scouts_digital_url' => env('SSALUTE_SCOUTS_DIGITAL_URL', 'https://ssa.scouts.digital'),

    /*
    |--------------------------------------------------------------------------
    | Scouts Digital hand-off
    |--------------------------------------------------------------------------
    |
    | The shared secret Scouts Digital signs its "Log in via Scouts.Digital"
    | tokens with (GET /sso/scouts-digital?token=...). It must equal
    | SSO_SSALUTE_SECRET in Scouts Digital's .env, where SSO_SSALUTE_ENABLED=1
    | switches that side on. Empty keeps the route a 404 and hides the button
    | on the login page.
    |
    */

    'scouts_digital_sso_secret' => env('SSALUTE_SCOUTS_DIGITAL_SSO_SECRET', ''),
];
