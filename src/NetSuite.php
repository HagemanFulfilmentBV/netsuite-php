<?php

namespace Hageman\NetSuite;

use Exception;
use Illuminate\Support\Arr;

class NetSuite
{
    /**
     * @var array
     */
    private static $config = [];

    /**
     * Load the related config file if it exists.
     *
     * @param $fileName
     * @return void
     */
    private static function loadFile($fileName)
    {
        $file = __DIR__ . '/../config/' . $fileName . '.php';

        if(is_file($file)) static::$config[$file] = require($file);
    }

    /**
     * Get config value or return default.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public static function config($key, $default = null)
    {
        /* Try to load config from application container */
        try {
            return config($key, $default);
        } catch(Exception $e) {
            // Skip error
        }

        /* Check for set */
        if(is_array($key) && is_null($default)) {
            foreach(Arr::dot($key) as $k => $v) data_set(static::$config, $k, $v);

            return true;
        }

        /* Load the static config from file */
        $segments = explode('.', $key);

        $fileName = array_shift($segments);

        if(!isset(static::$config[$fileName])) self::loadFile($fileName);

        return data_get(static::$config, $key, $default);
    }
}