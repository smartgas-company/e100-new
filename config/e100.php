<?php

return [
    'api_url'                 => env(
        'E100_API_URL',
        'https://api-integration.cloud.neo100.io/partner-api/'
    ),
    'client_id'               => env(
        'E100_CLIENT_ID',
        '69j7nkfaa96i0jadbiphh6ttbh'
    ),
    'client_secret'           => env(
        'E100_CLIENT_SECRET',
        'dldahmeahm8bkc89p5vs3g9tubj55ea3pq68u6ta7e3bgkrj26v'
    ),
    'payment_system'          => env('E100_PAYMENT_SYSTEM', 'e100Pro'),
    'payment_id'              => env(
        'E100_PAYMENT_ID',
        'a0550b55-c300-4091-94fe-935cdaf47613'
    ),
    'username'                => env('E100_USERNAME', 'SmartGasKZRest'),
    'password'                => env('E100_PASSWORD', 'S1G8K=Z!'),
    'api_get_cards_url'       => env(
        'E100_API_GET_CARDS_URL',
        'https://analitic.euprocessing.com:48100/'
    ),
    'helios_corp_client_card' => env('E100_API_HELIOS_CORP_CARD', '0')
];