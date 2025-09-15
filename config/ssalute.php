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
];
