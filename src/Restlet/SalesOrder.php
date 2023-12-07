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
        'administrationCode' => null,
        'projectGroup' => null,
        'invoice' => [
            'address' => [
                'address2' => null,
                'city' => null,
                'company' => null,
                'contact' => null,
                'contactPhoneNumber' => null,
                'countryCode' => null,
                'emailAddress' => null,
                'extension' => null,
                'faxNumber' => null,
                'phoneNumber' => null,
                'postalCode' => null,
                'street' => null,
                'streetNumber' => null,
                'subCountryCode' => null,
                'vatNumber' => null
            ],
            'currency' => null,
            'debtorCode' => null,
            'digital' => null,
            'heartbeat' => [
                'exhortation' => null,
                'notice' => null,
                'reminder' => null
            ],
            'language' => null,
            'paid' => null,
            'payDate' => null,
            'prefix' => null,
            'sent' => null,
            'subject' => null
        ],
        'item' => [
            [
                'invoice' => null,
                'itemDescription' => null,
                'itemInformation' => null,
                'itemNumber' => null,
                'price' => null,
                'quantity' => null,
                'type' => null,
                'unit' => null,
                'vat' => null
            ]
        ],
        'language' => null,
        'orderDate' => null,
        'orderInformation' => null,
        'reference' => null,
        'reference2' => null,
        'requestedDeliveryDate' => null,
        'shipping' => [
            'address' => [
                'address2' => null,
                'city' => null,
                'company' => null,
                'contact' => null,
                'contactPhoneNumber' => null,
                'countryCode' => null,
                'emailAddress' => null,
                'extension' => null,
                'faxNumber' => null,
                'phoneNumber' => null,
                'postalCode' => null,
                'street' => null,
                'streetNumber' => null,
                'subCountryCode' => null
            ],
            'carrierCode' => null,
            'deliveryCondition' => null,
            'deliveryMode' => null,
            'labelServiceCode' => null,
        ],
        'webshopCode' => null
    ];

    /**
     * Creates a new SalesOrder instance.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        static::$script = NetSuite::config('netsuite.restlet.SalesOrder.script');

        $defaults = NetSuite::config('netsuite.restlet.SalesOrder.defaults', []);

        foreach(Arr::dot($defaults) as $k => $v) data_set($this->data, $k, $v);

        parent::__construct($data);
    }
}
