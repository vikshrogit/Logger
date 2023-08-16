<?php 
namespace Ramphp\Logger;

class App_config
{
    private static $app_config;

    /**
      * @param mixed $app_config
    */
    public static function setAppConfig(mixed $app_config): void
    {
        self::$app_config = $app_config;
    }
    public static function get($key, $default = null): mixed
    {
        if (is_null(self::$app_config)) {
            self::$app_config = require_once(__DIR__.'/../app_config.php');
        }

        return !empty(self::$app_config[$key])?self::$app_config[$key]:$default;
    }
}