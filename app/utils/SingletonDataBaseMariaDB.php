<?php

namespace Supalta\Cannelle\utils;

class SingletonDataBaseMariaDB
{
    private \PDO $pdo;

    private static ?SingletonDataBaseMariaDB $instance = null ;

    /**
     * Get mariaDB config from config.ini with an instance of SingletonConfigReader
     * @throws \Exception If arg "section" is wrong
     */
    private function __construct() {
        $config = SingletonConfigReader::getInstance();

        $this->pdo = new \PDO(
            $config->getValue("dsn","mariaDb"),
            $config->getValue("username","mariaDb"),
            $config->getValue("password","mariaDb")
        );
    }

    /**
     * Allow to create an instance of SingletonDataBasaMariaDB out of this file
     * @return SingletonDataBaseMariaDB
     */
    public static function getInstance() : SingletonDataBaseMariaDB {
        if(is_null(self::$instance)) {
            self::$instance = new SingletonDataBaseMariaDB();
        }
        return self::$instance;
    }

    /**
     * @return \PDO
     */
    public function getPDO() : \PDO {
        return $this->pdo;
    }

//    public function getLoggedPDO(): \PDO { //FIXME : Write LoggedPDO Class
//
//    }

}
