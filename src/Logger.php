<?php
namespace Ramphp\Logger;

class Logger extends \Ramphp\Logger\lib\Logger{
    public function __construct($key = "ram_app", $app_config = null)
    {
        parent::__construct($key, $app_config);
    }
}