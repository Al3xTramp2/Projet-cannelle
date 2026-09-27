<?php

namespace Supalta\Cannelle\model;

use DateTime;
use Exception;

/**
 * Class Pompier
 * @package Supalta\Cannelle\model
 */
class Pompier extends \stdClass {

    private string $Matricule;
    private string $Prenom;
    private string $Nom;
    private string $ChefAgret;
    private DateTime $DateNaissance;
    private int $NumCaserne;
    private string $CodeGrade;
    private string $MatriculeRespo;

    /**
     * @return string
     */
    public function getMatricule(): string {
        return $this->Matricule;
    }

    /**
     * @param string $Matricule
     * @return $this
     * @throws Exception
     */
    public function setMatricule(string $Matricule): Pompier {
        if (mb_strlen($Matricule) !== 7) {
            throw new Exception("Le matricule doit contenir exactement 7 caractères !");
        }
        if (substr($Matricule, 0, 2) !== "Ma") {
            throw new Exception("Le matricule doit commencer par 'Ma' !");
        }
        if (!ctype_digit(substr($Matricule, -5))) {
            throw new Exception("Les 5 derniers caractères du matricule doivent être des chiffres !");
        }
        $this->Matricule = $Matricule;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom(): string{
        return $this->Prenom;
    }

    /**
     * @param string $Prenom
     * @return $this
     * @throws Exception
     */
    public function setPrenom(string $Prenom): Pompier {
        if ($Prenom === "") {
            throw new Exception("Le prénom ne peut pas être vide !");
        }
        if (mb_strlen($Prenom) > 10) {
            throw new Exception("Le prénom ne peut pas dépasser 10 caractères !");
        }
        $this->Prenom = $Prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string {
        return $this->Nom;
    }

    /**
     * @param string $Nom
     * @return $this
     * @throws Exception
     */
    public function setNom(string $Nom): Pompier {
        if ($Nom === "") {
            throw new Exception("Le nom ne peut pas être vide !");
        }
        if (mb_strlen($Nom) > 20) {
            throw new Exception("Le nom ne peut pas dépasser 20 caractères !");
        }
        $this->Nom = $Nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getChefAgret(): string {
        return $this->ChefAgret;
    }

    /**
     * @param string $ChefAgret
     * @return $this
     * @throws Exception
     */
    public function setChefAgret(string $ChefAgret): Pompier {
        if (!in_array($ChefAgret, ["O", "N"])) {
            throw new Exception("Le chef d'agrément doit être 'O' ou 'N' !");
        }
        $this->ChefAgret = $ChefAgret;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateNaissance(): DateTime {
        return $this->DateNaissance;
    }

    /**
     * @param DateTime $DateNaissance
     * @return $this
     * @throws Exception
     */
    public function setDateNaissance(DateTime $DateNaissance): Pompier {
        if ($DateNaissance > new DateTime()) {
            throw new Exception("La date de naissance ne peut pas être dans le futur !");
        }
        $this->DateNaissance = $DateNaissance;
        return $this;
    }

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
    public function setNumCaserne(int $NumCaserne): Pompier {
        if ($NumCaserne <= 0) {
            throw new Exception("Le numéro de caserne doit être positif !");
        }
        $this->NumCaserne = $NumCaserne;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeGrade(): string {
        return $this->CodeGrade;
    }

    /**
     * @param string $CodeGrade
     * @return $this
     * @throws Exception
     */
    public function setCodeGrade(string $CodeGrade): Pompier {
        $grades = ["1C", "AC", "Ad", "Ca", "CC", "Ct", "In", "Lt", "Ma", "SC", "Sg", "SP"];
        if (!in_array($CodeGrade, $grades)) {
            throw new Exception("Le code de grade n'est pas valide !");
        }
        $this->CodeGrade = $CodeGrade;
        return $this;
    }

    /**
     * @return string
     */
    public function getMatriculeRespo(): string {
        return $this->MatriculeRespo;
    }


    /**
     * @param string $MatriculeRespo
     * @return $this
     * @throws Exception
     */
    public function setMatriculeRespo(string $MatriculeRespo): Pompier {
        if (mb_strlen($MatriculeRespo) !== 7) {
            throw new Exception("Le matricule  doit contenir exactement 7 caractères !");
        }
        if (!str_starts_with($MatriculeRespo, "Ma")) {
            throw new Exception("Le matricule doit commencer par 'Ma' !");
        }
        if (!ctype_digit(substr($MatriculeRespo, -5))) {
            throw new Exception("Les 5 derniers caractères du matricule doivent être des chiffres !");
        }
        $this->MatriculeRespo = $MatriculeRespo;
        return $this;
    }

}
