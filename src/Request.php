<?php

namespace Hageman\NetSuite;

use Hageman\NetSuite\Auth\OAuth;
use JsonSerializable;

final class Request implements JsonSerializable
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array|string|null
     */
    private $data;

    /**
     * Initiates a new request.
     *
     * @param string            $method
     * @param string            $url
     * @param array|null        $parameters
     * @param array|string|null $data
     */
    public function __construct(string $method, string $url, array $parameters = null, $data = null)
    {
        if (is_array($data)) $data = empty($data) ? null : json_encode($data);


        $this->url = $url;

        $this->parameters = $parameters;

        $this->data = $data;

        $this->method = strtoupper($method);

        $this->request();
    }

    /**
     * Perform a curl request on the ServiceLayer.
     *
     * @return void
     */
    private function request(): void
    {
        Restlet::$request = $this;

        $oAuth = OAuth::new()->url($this->url)->method($this->method)->parameters($this->parameters);

        $curlOptions = [
            CURLOPT_URL => $this->url . (!empty($this->parameters) ? '?' . http_build_query($this->parameters) : ''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $oAuth->asString(),
            ],
        ];

        if (in_array($this->method, ['POST', 'PUT'])) {
            $curlOptions[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = $this->data;
        }

        $curl = curl_init();

        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);

        if(curl_error($curl)) {
            $response = [
                'code' => 500,
                'message' => curl_error($curl),
                'success' => false,
                'data' => $response,
            ];
        } else {
            $response = json_decode($response, true);

            $response = [
                'code' => isset($response['error']) ? 400 : ($response['status'] ?? 200),
                'message' => isset($response['error']) ? ($response['error']['message'] ?? '') : ($response['message'] ?? ''),
                'success' => !isset($response['error']),
                'data' => $response,
            ];
        }

        curl_close($curl);

        Restlet::$response = new Response(
            $response['code'] ?? 204,
            $response['message'] ?? 'No content',
            $response['success'] ?? false,
            $response['data'] ?? null
        );
    }

    /**
     * Return the response of handled request when class is called as a function.
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this::get_latest_response();
    }

    /**
     * Return the latest response of the ServiceLayer or create a new 'No Content' response.
     *
     * @return Response
     */
    private static function get_latest_response(): Response
    {
        return Restlet::$response ?? new Response(...[
                'code' => $response['code'] ?? 204,
                'message' => $response['message'] ?? 'No content',
                'success' => $response['success'] ?? false,
                'data' => $response['data'] ?? null,
            ]);
    }

    /**
     * Return the request as a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return "$this->url: ($this->method)" . ($this->count() ? " [data:{$this->count()}]" : '');
    }

    /**
     * Return to data count of the request.
     *
     * @return int
     */
    public function count(): int
    {
        if(is_null($this->data)) return 0;

        $data = is_string($this->data) ? json_decode($this->data, true) : $this->data;

        return is_array($data) ? count($data) : 0;
    }

    /**
     * Return an array with some attributes of the request.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'data' => $this->data,
            'method' => $this->method,
            'url' => $this->url,
            'parameters' => $this->parameters,
        ];
    }

    /**
     * Return the data that was sent in request.
     *
     * @return array|string|null
     */
    public function getData()
    {
        return $this->data;
    }
}
