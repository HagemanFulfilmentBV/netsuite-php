<?php

namespace Hageman\NetSuite\Restlet;

use Hageman\NetSuite\NetSuite;
use Hageman\NetSuite\Restlet;
use Illuminate\Support\Arr;

class SalesOrder extends Restlet
{
    /**
     * ID of the Restlet script.
     *
     * @var int
     */
    protected static $script;

    /**
     * Dataset for request.
     *
     * @var array
     */
    protected $data = [
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
    ];

    /**
     * Creates a new SalesOrder instance.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        static::$script = NetSuite::config('netsuite.restlet.SalesOrder.script');

        $defaults = NetSuite::config('netsuite.restlet.SalesOrder.defaults');

        if(!empty($defaults)) foreach(Arr::dot($defaults) as $k => $v) data_set($this->data, $k, $v);

        parent::__construct($data);
    }
}
