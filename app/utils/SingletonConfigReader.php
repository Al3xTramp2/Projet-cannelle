<?php

namespace Supalta\Cannelle\utils;

use http\Exception;

class SingletonConfigReader
{
    private static SingletonConfigReader $instance;

    private $data = [];

    private function __construct() {
        $fichierConfig = "../config.ini";
        $this->data = parse_ini_file($fichierConfig, true);
    }

    public static function getInstance(): SingletonConfigReader{
        if(!isset(self::$instance)) {
            self::$instance = new SingletonConfigReader();
        }
        return self::$instance;
    }

    /**
     * return the value associated to the key in the defined section
     * @param string $key
     * @param string|null $section
     * @return string|null
     */
    public function getValue(string $key, ?string $section = null): ?string {
        if(is_null($section)){
            throw new \Exception("la section est vide");
        }
        return $this->data[$section][$key];
    }


}