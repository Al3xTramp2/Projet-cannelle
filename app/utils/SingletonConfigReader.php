<?php

namespace Supalta\Cannelle\utils;

class SingletonConfigReader
{
    private static SingletonConfigReader $instance;

    private $data = [];

    /**
     * Loads config.ini and keeps it in memory
     */
    private function __construct() {
        $fichierConfig = __DIR__ . "/../../config.ini";
        $this->data = parse_ini_file($fichierConfig, true);
    }

    /**
     * Allow to create an instance of SingletonConfigReader out of this file
     * @return SingletonConfigReader
     */
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