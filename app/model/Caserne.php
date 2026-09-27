<?php

namespace Supalta\Cannelle\model;

use Exception;

/**
 * Class Caserne
 * @package Supalta\Cannelle\model
 */
class Caserne extends \stdClass{

    private int $NumCaserne;
    private string $Adresse;
    private string $CP;
    private string $Ville;
    private int $CodeTypeC;

    /**
     * @return int
     */
    public function getNumCaserne(): int {
        return $this->NumCaserne;
    }

    /**
     * @param int $NumCaserne
     * @return $this
     * @throws Exception
     */
    public function setNumCaserne(int $NumCaserne): Caserne {
        if ($NumCaserne <= 0) {
            throw new Exception("Le numéro de caserne doit être positif !");
        }
        $this->NumCaserne = $NumCaserne;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse(): string {
        return $this->Adresse;
    }

    /**
     * @param string $Adresse
     * @return $this
     * @throws Exception
     */
    public function setAdresse(string $Adresse): Caserne {
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
     * @return string
     */
    public function getCP(): string {
        return $this->CP;
    }

    /**
     * @param string $CP
     * @return $this
     * @throws Exception
     */
    public function setCP(string $CP): Caserne {
        if (mb_strlen($CP) !== 5 || !ctype_digit($CP)) {
            throw new Exception("Le code postal doit contenir exactement 5 chiffres !");
        }
        $this->CP = $CP;
        return $this;
    }

    /**
     * @return string
     */
    public function getVille(): string {
        return $this->Ville;
    }

    /**
     * @param string $Ville
     * @return $this
     * @throws Exception
     */
    public function setVille(string $Ville): Caserne {
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
     * @return int
     */
    public function getCodeTypeC(): int {
        return $this->CodeTypeC;
    }

    /**
     * @param int $CodeTypeC
     * @return $this
     * @throws Exception
     */
    public function setCodeTypeC(int $CodeTypeC): Caserne {
        if (!in_array($CodeTypeC, [1, 2, 3])) {
            throw new Exception("Le code de type de caserne doit être '1', '2' ou '3' !");
        }
        $this->CodeTypeC = $CodeTypeC;
        return $this;
    }

}
