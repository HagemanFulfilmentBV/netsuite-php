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

                // It is possible to override the default data load of this class
                'defaults' => [
                    'administrationCode' => 0,
                    'subsidiary' => 0,
                    'projectGroup' => 0,
                    'webshopCode' => 0,
                ]
            ]
        ]
    ];
