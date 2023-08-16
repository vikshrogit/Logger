<?php 
namespace Ramphp\Logger\lib;

use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Ramphp\Logger\App_config;

class Logger extends \Monolog\Logger
{
    private static array $log_sys = [];

    /**
     * @param $key
     * @param $app_config
     */
    public function __construct($key = "ram_app", $app_config = null)
    {
        parent::__construct($key);

        if (empty($app_config)) {
            $LOG_PATH = App_config::get('LOG_PATH', __DIR__ . '/../../logs');
            $app_config = [
                'logFile' => "{$LOG_PATH}/{$key}.log",
                'logLevel' => 100
            ];
        }

        $this->pushHandler(new StreamHandler($app_config['logFile'], $app_config['logLevel']));
    }

    /**
     * @param string $key
     * @param $app_config
     * @return mixed
     */
    public static function getInstance(string $key = "OluO_app", $app_config = null): mixed
    {
        if (empty(self:: $log_sys[$key])) {
            self:: $log_sys[$key] = new Logger($key, $app_config);
        }

        return self:: $log_sys[$key];
    }

    /**
     * @return void
     */
    public static function enableSystemLogs(): void
    {

        $LOG_PATH = App_config::get('LOG_PATH', __DIR__ . '/../../logs');
        // Error Log
        self::$log_sys['error'] = new Logger('errors');
        self:: $log_sys['error']->pushHandler(new StreamHandler("{$LOG_PATH}/errors.log"));
        ErrorHandler::register(self::$log_sys['error']);

        // Request Log
        $data = [
            $_SERVER,
            $_REQUEST,
            trim(file_get_contents("php://input"))
        ];
        self::$log_sys['request'] = new Logger('request');
        self::$log_sys['request']->pushHandler(new StreamHandler("{$LOG_PATH}/request.log",100));
        self::$log_sys['request']->info("REQUEST", $data);
    }

    /**
     * @return array
     */
    public static function getLogSys(): array
    {
        return self::$log_sys;
    }

    /**
     * @param array $log_sys
     * @return void
     */
    public static function setLogSys(array $log_sys): void
    {
        self::$log_sys = $log_sys;
    }
}