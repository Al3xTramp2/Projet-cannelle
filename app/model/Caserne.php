<?php

namespace Supalta\Cannelle\model;

use Exception;

/**
 * Class Caserne
 * @package Supalta\Cannelle\model
 */
class Caserne extends \stdClass
{
    public const array TYPES = [
        "1" => "Pro",
        "2" => "Mixte",
        "3" => "Volontaire"
    ];

    private int $NumCaserne;
    private string $Adresse;
    private string $CP;
    private string $Ville;
    private int $CodeTypeC;

    /**
     * Return the number of the caserne
     * @return int
     */
    public function getNumCaserne(): int
    {
        return $this->NumCaserne;
    }

    /**
     * Set the number of the caserne
     * @param int $NumCaserne
     * @return $this
     * @throws Exception
     */
    public function setNumCaserne(int $NumCaserne): Caserne
    {
        if ($NumCaserne <= 0) {
            throw new Exception("Le numéro de caserne doit être positif !");
        }
        $this->NumCaserne = $NumCaserne;
        return $this;
    }

    /**
     * Return the address of the caserne
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->Adresse;
    }

    /**
     * Set the address of the caserne
     * @param string $Adresse
     * @return $this
     * @throws Exception
     */
    public function setAdresse(string $Adresse): Caserne
    {
        if ($Adresse === "") {
            throw new Exception("L'adresse ne peut pas être vide !");
        }
        if (mb_strlen($Adresse) > 15) {
            throw new Exception("L'adresse doit contenir un maximum de 15 caractères !");
        }
        $this->Adresse = $Adresse;
        return $this;
    }

    /**
     * Return the postal code of the caserne
     * @return string
     */
    public function getCP(): string
    {
        return $this->CP;
    }

    /**
     * Set the postal code of the caserne
     * @param string $CP
     * @return $this
     * @throws Exception
     */
    public function setCP(string $CP): Caserne
    {
        if (mb_strlen($CP) !== 5 || !ctype_digit($CP)) {
            throw new Exception("Le code postal doit contenir exactement 5 chiffres !");
        }
        $this->CP = $CP;
        return $this;
    }

    /**
     * Return the city of the caserne
     * @return string
     */
    public function getVille(): string
    {
        return $this->Ville;
    }

    /**
     * Set the city of the caserne
     * @param string $Ville
     * @return $this
     * @throws Exception
     */
    public function setVille(string $Ville): Caserne
    {
        if ($Ville === "") {
            throw new Exception("Le nom de la ville ne peut pas être vide !");
        }
        if (mb_strlen($Ville) > 20) {
            throw new Exception("Le nom de la ville doit contenir un maximum de 20 caractères !");
        }
        $this->Ville = $Ville;
        return $this;
    }

    /**
     * Return the code of the type of the caserne
     * @return int
     */
    public function getCodeTypeC(): int
    {
        return $this->CodeTypeC;
    }

    /**
     * Set the code of the type of the caserne
     * @param int $CodeTypeC
     * @return $this
     * @throws Exception
     */
    public function setCodeTypeC(int $CodeTypeC): Caserne
    {
        if (!array_key_exists((string)$CodeTypeC, self::TYPES)) {
            throw new Exception("Le code de type de caserne n'est pas valide !");
        }
        $this->CodeTypeC = $CodeTypeC;
        return $this;
    }

    /**
     * Return the name of the type of the Caserne according to its code
     * @return string
     */
    public function getType(): string
    {
        return self::TYPES[(string)$this->CodeTypeC];
    }
}
