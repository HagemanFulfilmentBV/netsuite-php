<?php

namespace Hageman\NetSuite;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use JsonSerializable;

abstract class Restlet implements JsonSerializable
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
     * @var array|null
     */
    protected $data = null;

    /**
     * The latest request from the ServiceLayer.
     *
     * @var Request|null
     */
    public static $request;

    /**
     * The latest response from the ServiceLayer.
     *
     * @var Response|null
     */
    public static $response;

    /**
     * Creates a new Restlet instance.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        if(!is_null($data)) foreach(Arr::dot($data) as $k => $v) data_set($this->data, $k, $v);
    }

    /**
     * Get a value from the data set.
     *
     * @param $name
     * @return array|mixed
     */
    public function __get($name)
    {
        return data_get($this->data, $name);
    }

    /**
     * Set a value on the data set.
     *
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        data_set($this->data, $name, $value);
    }

    /**
     * Creates a new Restlet instance.
     *
     * @param array|null $data
     * @return Restlet
     */
    public static function new(array $data = null): Restlet
    {
        return new static($data);
    }

    /**
     * Get current dataset.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return collect($this->data);
    }

    /**
     * Filters all NULL values recursively from the array.
     *
     * @param array $array
     * @return array
     */
    private function multiFilter(array $array): array
    {
        foreach($array as $k => $v) {
            if(is_array($v)) {
                $v = $this->multiFilter($v);

                if(empty($v)) {
                    unset($array[$k]);
                } else {
                    $array[$k] = $v;
                }
            } else {
                if(is_null($v)) unset($array[$k]);
            }
        }

        return $array;
    }

    /**
     * Create a request on the Restlet.
     *
     * @param null $method
     * @return Response
     */
    public function send($method = null): Response
    {
        return (new Request(is_null($method) ? (is_null($this->data) ? 'GET' : 'POST') : $method, NetSuite::config('netsuite.restlet.url'), [
            'deploy' => 1,
            'script' => static::$script,
        ], $this->multiFilter($this->get()->toArray())))();
    }

    /**
     * Return an array with some attributes of the request.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->get()->toArray();
    }
}
