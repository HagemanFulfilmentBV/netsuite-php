<?php

namespace Hageman\NetSuite;

use Exception;

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
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public static function config(string $key, $default = null)
    {
        /* Try to load config from application container */
        try {
            return config($key, $default);
        } catch(Exception $e) {
            // Skip error
        }

        /* Load the static config from file */
        $segments = explode('.', $key);

        $fileName = array_shift($segments);

        if(!isset(static::$config[$fileName])) self::loadFile($fileName);

        return data_get(static::$config, $key, $default);
    }
}