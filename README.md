# Hageman - NetSuite - PHP library
An open source PHP library free to use and collaborate. This package contains classes to interact with the NetSuite ERP.

## Installation  
Run the following in your CLI:
```cli
composer require hageman/netsuite-php
```

## Configuration

___Note:__ Some configuration values are customer- or even application specific and to be provided by Hageman._

### For Laravel integrations  
Run the following in your CLI:
```cli
php artisan vendor:publish --tag=hageman-netsuite-php
```
and adjust the config file (`config/netsuite.php`) to your needs.

### For other integrations  
Set an array with your options as parameter for the config function, prior to calling other methods or functions of the library:  
```php
\Hageman\NetSuite::config([
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
            ],           
        ],
    ],
]);
```

## Available methods

### create SalesOrder
```php
$salesOrder = new \Hageman\NetSuite\Restlet\SalesOrder([
    'administrationCode' => null,           // Customer number at Hageman
    'subsidiary' => null,                   // Subsidiary in NetSuite
    'projectGroup' => null,                 // Project group code
    'webshopCode' => null,                  // Webshop code for label provider
    'language' => null,                     // Language used on order documents
    'orderDate' => null,                    // Date of order
    'orderInformation' => null,             // Additional information
    'reference' => null,                    // Order number
    'reference2' => null,                   // Additional reference, mostly PO number
    'requestedDeliveryDate' => null,        // Optional delivery date
    'invoice' => [
        'currency' => null,                 // Currency
        'debtorCode' => null,               // Customer / User ID in webshop
        'digital' => null,                  // Should receive invoice by email (true/false)
        'language' => null,                 // Language used on invoice
        'paid' => null,                     // Order has been fully paid
        'payDate' => null,                  // Date of payment
        'address' => [
            'company' => null,              // Company name
            'contact' => null,              // Full name of contact
            'street' => null,               // Street / Primary address line
            'streetNumber' => null,         // Street number (required for NL)
            'extension' => null,            // Street number extension
            'address2' => null,             // Secondary address line
            'city' => null,                 // City
            'postalCode' => null,           // Postal code
            'subCountryCode' => null,       // Province or state code
            'countryCode' => null,          // Country code
            'faxNumber' => null,            // Fax number
            'phoneNumber' => null,          // Phone number
            'emailAddress' => null,         // Email address
            'contactPhoneNumber' => null,   // Phone number of contact
            'vatNumber' => null,            // VAT number
        ],
        'heartbeat' => [
            'reminder' => null,             // First reminder # days after invoice date
            'exhortation' => null,          // Second reminder # days after reminder
            'notice' => null,               // Final reminder # days after exhortation
        ],
        'payment' => [
            'bic' => null,                  // BIC used for payment
            'iban' => null,                 // IBAN used for payment
            'provider' => null,             // Payment provider
            'reference' => null,            // Payment reference number
            'transactionId' => null,        // Transaction ID of payment            
            'url' => null,                  // URL of payment
        ],
    ],
    'shipping' => [
        'deliveryCondition' => null,        // Preferred delivery condition
        'deliveryMode' => null,             // Preferred delivery method
        'address' => [
            'company' => null,              // Company name
            'contact' => null,              // Full name of contact
            'street' => null,               // Street / Primary address line
            'streetNumber' => null,         // Street number (required for NL)
            'extension' => null,            // Street number extension
            'address2' => null,             // Secondary address line
            'city' => null,                 // City
            'postalCode' => null,           // Postal code
            'subCountryCode' => null,       // Province or state code
            'countryCode' => null,          // Country code
            'faxNumber' => null,            // Fax number
            'phoneNumber' => null,          // Phone number
            'emailAddress' => null,         // Email address
            'contactPhoneNumber' => null,   // Phone number of contact
        ],
    ],
    'item' => [                             // One or multiple
        [
            'itemDescription' => null,      // Description of item
            'itemNumber' => null,           // Item number
            'price' => null,                // Sale price per unit
            'quantity' => null,             // Quantity sold
            'type' => null,                 // Type of item: product, shipping, discount
            'unit' => null,                 // Item unit
        ]
    ],
]);
```

Source code managed via GitHub: https://github.com/HagemanFulfilmentBV/netsuite-php

<img src="https://badgen.net/packagist/lang/hageman/netsuite-php" alt="language">
<img src="https://badgen.net/packagist/php/hageman/netsuite-php" alt="php">
<img src="https://badgen.net/packagist/license/hageman/netsuite-php" alt="license">
<img src="https://badgen.net/packagist/v/hageman/netsuite-php" alt="version">
<img src="https://badgen.net/packagist/dt/hageman/netsuite-php" alt="downloads">