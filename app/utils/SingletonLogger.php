<?php

namespace Supalta\Cannelle\utils;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

class SingletonLogger
{
    private ?Logger $sqlLogger = null;
    private ?Logger $accessLogger = null;
    private static ?SingletonLogger $instance = null;

    /** @var array<string, string> */
    private array $SQLLoggerConfig = [
        "path" => __DIR__ . "/../../storage/logs/sql.log",
        "level" => "Info"
    ];

    /** @var array<string, string> */
    private array $AccessLoggerConfig = [
        "path" => __DIR__ . "/../../storage/logs/access.log",
        "level" => "Warning"
    ];

    /**
     * @throws Exception
     */
    private function __construct()
    {
        $config = SingletonConfigReader::getInstance();

        try {
            $sqlPath = $config->getValue("path", "SQLLogger");
        } catch (Exception) {
            $sqlPath = $this->SQLLoggerConfig["path"];
        }

        try {
            $sqlLevel = Level::fromName($config->getValue("level", "SQLLogger"));
        } catch (Exception) {
            $sqlLevel = Level::fromName($this->SQLLoggerConfig["level"]);
        }

        $this->sqlLogger = new Logger("SQLLogger");
        $this->sqlLogger->pushHandler(new StreamHandler($sqlPath, $sqlLevel));

        try {
            $accessPath = $config->getValue("path", "AccessLogger");
        } catch (Exception) {
            $accessPath = $this->AccessLoggerConfig["path"];
        }

        try {
            $accessLevel = Level::fromName($config->getValue("level", "AccessLogger"));
        } catch (Exception) {
            $accessLevel = Level::fromName($this->AccessLoggerConfig["level"]);
        }

        $this->accessLogger = new Logger("AccessLogger");
        $this->accessLogger->pushProcessor(new WebProcessor());
        $this->accessLogger->pushHandler(new StreamHandler($accessPath, $accessLevel));
    }

    /**
     * @return SingletonLogger
     */
    public static function getInstance(): SingletonLogger
    {
        if (is_null(self::$instance)) {
            self::$instance = new SingletonLogger();
        }
        return self::$instance;
    }

    /**
     * @return Logger
     */
    public function getSQLLogger(): Logger
    {
        return $this->sqlLogger;
    }

    /**
     * @return Logger
     */
    public function getAccessLogger(): Logger
    {
        return $this->accessLogger;
    }
}
