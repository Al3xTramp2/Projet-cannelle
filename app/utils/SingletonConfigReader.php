<?php

namespace Supalta\Cannelle\utils;

class SingletonConfigReader
{
    private static SingletonConfigReader $instance;

    private array $data;

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
     * @throws \Exception
     */
    public function getValue(string $key, ?string $section = null): ?string {
        if (is_null($section)){
            if (array_key_exists($key, $this->data)){
                return $this->data[$key];
            }
            throw new \Exception("La clé '$key' n'existe pas !");
        }
        if (!array_key_exists($section, $this->data)){
            throw new \Exception("La section '$section' n'existe pas !");
        }
        if (array_key_exists($key, $this->data[$section])){
            return $this->data[$section][$key];
        }
        throw new \Exception("La clé '$key' n'existe pas dans la section '$section' !");
    }

}
