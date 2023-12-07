<?php
    return [

        /*
        |--------------------------------------------------------------------------
        | NetSuite
        |--------------------------------------------------------------------------
        |
        | Here you can edit the config for the NetSuite connection.
        |
        */
        'signature-method' => 'HMAC-SHA256',
        'account' => '',
        'realm' => '',
        'consumer' => [
            'key' => '',
            'secret' => '',
        ],
        'token' => [
            'key' => '',
            'secret' => '',
        ],

        /*
        |--------------------------------------------------------------------------
        | Restlet specific config
        |--------------------------------------------------------------------------
        */
        'restlet' => [
            'url' => '',

            'SalesOrder' => [
                'script' => 0,
                'defaults' => [
                    'administrationCode' => 0,
                    'projectGroup' => 0,
                ]
            ]
        ]
    ];
