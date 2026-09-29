<?php

namespace Supalta\Cannelle\utils;

use Exception;
use PDO;

class SingletonDataBaseMariaDB {

    private PDO $pdo;
    private static ?SingletonDataBaseMariaDB $instance = null ;

    /**
     * Constructor of the SingletonDataBaseMariaDB class
     * @throws Exception
     */
    private function __construct() {
        $config = SingletonConfigReader::getInstance();

        $this->pdo = new PDO(
            $config->getValue("dsn","mariaDb"),
            $config->getValue("username","mariaDb"),
            $config->getValue("password","mariaDb")
        );
    }

    /**
     * Return the Singleton instance
     * @return SingletonDataBaseMariaDB
     */
    public static function getInstance() : SingletonDataBaseMariaDB {
        if(is_null(self::$instance)) {
            self::$instance = new SingletonDataBaseMariaDB();
        }
        return self::$instance;
    }

    /**
     * Return the PDO object
     * @return PDO
     */
    public function getPDO() : PDO {
        return $this->pdo;
    }

//    public function getLoggedPDO(): \PDO { //TODO : Write LoggedPDO Class
//
//    }

}
