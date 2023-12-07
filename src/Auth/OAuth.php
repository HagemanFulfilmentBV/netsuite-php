<?php

namespace Hageman\NetSuite\Auth;

use Hageman\NetSuite\NetSuite;

class OAuth
{
    /**
     * @var array
     */
    private $base;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $method = 'POST';

    /**
     * @var array
     */
    private $parameters;

    /**
     * Creates a new OAuth instance.
     */
    public function __construct()
    {
        $this->base = [
            'oauth_consumer_key' => NetSuite::config('netsuite.consumer.key'),
            'oauth_token' => NetSuite::config('netsuite.token.key'),
            'oauth_signature_method' => NetSuite::config('netsuite.signature-method'),
            'oauth_timestamp' => time(),
            'oauth_nonce' => uniqid(),
            'oauth_version' => '1.0',
        ];
    }

    /**
     * Creates a new OAuth instance.
     *
     * @return OAuth
     */
    public static function new(): OAuth
    {
        return new static();
    }

    /**
     * Set the URL.
     *
     * @param string $url
     * @return OAuth
     */
    public function url(string $url): OAuth
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the method.
     *
     * @param string $method
     * @return OAuth
     */
    public function method(string $method): OAuth
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set the parameters.
     *
     * @param array $parameters
     * @return OAuth
     */
    public function parameters(array $parameters): OAuth
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get the OAuth attributes as array.
     *
     * @return array
     */
    public function get(): array
    {
        $parameters = array_merge($this->base, $this->parameters);

        ksort($parameters);

        $baseString = implode('&', [$this->method, rawurlencode($this->url), rawurlencode(http_build_query($parameters))]);

        $signatureKey = rawurlencode(NetSuite::config('netsuite.consumer.secret')) . '&' . rawurlencode(NetSuite::config('netsuite.token.secret'));

        $oauthSignature = base64_encode(hash_hmac(strtolower(str_replace('HMAC-', '', NetSuite::config('netsuite.signature-method'))), $baseString, $signatureKey, true));

        return array_merge($this->base, [
            'oauth_signature' => $oauthSignature,
        ]);
    }

    /**
     * Get the OAuth authorization string.
     *
     * @return string
     */
    public function asString(): string
    {
        $header = $this->get();

        $realm = !empty(NetSuite::config('netsuite.realm')) ? 'realm="' . NetSuite::config('netsuite.realm') . '", ' : '';

        return 'OAuth ' . $realm . implode(', ', array_map(function ($k, $v) {
            return "$k=\"" . rawurlencode($v) . '"';
        }, array_keys($header), $header));
    }

    /**
     * Get the OAuth authorization string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->asString();
    }
}
