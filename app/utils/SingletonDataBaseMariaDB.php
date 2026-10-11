<?php

namespace Supalta\Cannelle\utils;

use Exception;
use PDO;

/**
 * Provides the PDO connections to the MariaDB database (single instance)
 */
class SingletonDataBaseMariaDB
{
    /** Plain PDO connection */
    private PDO $pdo;
    /** PDO connection logging every query */
    private LoggedPDO $loggedPdo;
    /** Single instance of the class */
    private static ?SingletonDataBaseMariaDB $instance = null ;

    /**
     * Constructor of the SingletonDataBaseMariaDB class
     * @throws Exception
     */
    private function __construct()
    {
        $config = SingletonConfigReader::getInstance();

        $this->pdo = new PDO(
            $config->getValue("dsn", "mariaDb"),
            $config->getValue("username", "mariaDb"),
            $config->getValue("password", "mariaDb")
        );

        $this->loggedPdo = new LoggedPDO(
            $config->getValue("dsn", "mariaDb"),
            $config->getValue("username", "mariaDb"),
            $config->getValue("password", "mariaDb")
        );
    }

    /**
     * Return the Singleton instance
     * @return SingletonDataBaseMariaDB
     */
    public static function getInstance(): SingletonDataBaseMariaDB
    {
        if (is_null(self::$instance)) {
            self::$instance = new SingletonDataBaseMariaDB();
        }
        return self::$instance;
    }

    /**
     * Return the PDO object
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    /**
     * Return the PDO object that logs each query
     * @return PDO
     */
    public function getLoggedPDO(): PDO
    {
        return $this->loggedPdo;
    }
}
