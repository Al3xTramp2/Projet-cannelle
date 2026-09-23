<?php

namespace Supalta\Cannelle\utils;

class SingletonDataBaseMariaDB
{
    private string $dsn = "mysql:host=127.0.0.1;dbname=pompiersdb";
    private string $username = "pompiersdb_user";
    private string $password = "123+aze";
    private \PDO $pdo;
    private static ?SingletonDataBaseMariaDB $instance = null ;

    private function __construct() {
        $this->pdo = new \PDO ($this->dsn, $this->username, $this->password);
    }

    public static function getInstance() : SingletonDataBaseMariaDB {
        if(is_null(self::$instance)) {
            self::$instance = new SingletonDataBaseMariaDB();
        }
        return self::$instance;
    }

    public function getPDO() : \PDO {
        return $this->pdo;
    }

//    public function getLoggedPDO(): \PDO { //FIXME : Write LoggedPDO Class
//
//    }

}
