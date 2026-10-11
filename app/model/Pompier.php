<?php

namespace Supalta\Cannelle\model;

use DateTime;
use Exception;

/**
 * Class Pompier
 * @package Supalta\Cannelle\model
 */
class Pompier extends \stdClass
{
    /** Names of the grades indexed by their code */
    public const GRADES = [
        "1C" => "1ere classe",
        "AC" => "Adjudent Chef",
        "Ad" => "Adjudent",
        "Ca" => "Caporal",
        "CC" => "Caporal Chef",
        "Ct" => "Capitaine",
        "In" => "Infirmier",
        "Lt" => "Lieutenant",
        "Ma" => "Major",
        "SC" => "Sergent Chef",
        "Sg" => "Sergent",
        "SP" => "Sapeur"
    ];

    /** Matricule of the pompier (primary key) */
    private string $Matricule;
    /** First name of the pompier */
    private string $Prenom;
    /** Last name of the pompier */
    private string $Nom;
    /** Whether the pompier is a chef d'agret */
    private string $ChefAgret;
    /** Date of birth of the pompier */
    private DateTime $DateNaissance;
    /** Number of the caserne of the pompier, null if unassigned */
    private ?int $NumCaserne;
    /** Code of the grade of the pompier */
    private string $CodeGrade;
    /** Matricule of the superior, null if none */
    private ?string $MatriculeRespo;

    /**
     * Return the matricule of the pompier
     * @return string
     */
    public function getMatricule(): string
    {
        return $this->Matricule;
    }

    /**
     * Set the matricule of the pompier
     * @param string $Matricule
     * @return $this
     * @throws Exception
     */
    public function setMatricule(string $Matricule): Pompier
    {
        if (mb_strlen($Matricule) !== 7) {
            throw new Exception("Le matricule doit contenir exactement 7 caractères !");
        }
        if (!str_starts_with($Matricule, "Ma")) {
            throw new Exception("Le matricule doit commencer par 'Ma' !");
        }
        if (!ctype_digit(substr($Matricule, -5))) {
            throw new Exception("Les 5 derniers caractères du matricule doivent être des chiffres !");
        }
        $this->Matricule = $Matricule;
        return $this;
    }

    /**
     * Return the first name of the pompier
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->Prenom;
    }

    /**
     * Set the first name of the pompier
     * @param string $Prenom
     * @return $this
     * @throws Exception
     */
    public function setPrenom(string $Prenom): Pompier
    {
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
     * Return the last name of the pompier
     * @return string
     */
    public function getNom(): string
    {
        return $this->Nom;
    }

    /**
     * Set the last name of the pompier
     * @param string $Nom
     * @return $this
     * @throws Exception
     */
    public function setNom(string $Nom): Pompier
    {
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
     * Return the chef d'agret flag of the pompier
     * @return string
     */
    public function getChefAgret(): string
    {
        return $this->ChefAgret;
    }

    /**
     * Set the chef d'agret flag of the pompier
     * @param string $ChefAgret
     * @return $this
     * @throws Exception
     */
    public function setChefAgret(string $ChefAgret): Pompier
    {
        if (!in_array($ChefAgret, ["O", "N"])) {
            throw new Exception("Le chef d'agrès doit être 'O' ou 'N' !");
        }
        $this->ChefAgret = $ChefAgret;
        return $this;
    }

    /**
     * Return the date of birth of the pompier
     * @return DateTime
     */
    public function getDateNaissance(): DateTime
    {
        return $this->DateNaissance;
    }

    /**
     * Set the date of birth of the pompier
     * @param DateTime $DateNaissance
     * @return $this
     * @throws Exception
     */
    public function setDateNaissance(DateTime $DateNaissance): Pompier
    {
        if ($DateNaissance > new DateTime()) {
            throw new Exception("La date de naissance ne peut pas être dans le futur !");
        }
        $this->DateNaissance = $DateNaissance;
        return $this;
    }

    /**
     * Return the number of the caserne of the pompier
     * @return int|null
     */
    public function getNumCaserne(): ?int
    {
        return $this->NumCaserne;
    }

    /**
     * Set the number of the caserne of the pompier
     * @param int|null $NumCaserne
     * @return $this
     * @throws Exception
     */
    public function setNumCaserne(?int $NumCaserne): Pompier
    {
        if ($NumCaserne !== null && $NumCaserne <= 0) {
            throw new Exception("Le numéro de caserne doit être positif !");
        }
        $this->NumCaserne = $NumCaserne;
        return $this;
    }

    /**
     * Return the code of the grade of the pompier
     * @return string
     */
    public function getCodeGrade(): string
    {
        return $this->CodeGrade;
    }

    /**
     * Set the code of the grade of the pompier
     * @param string $CodeGrade
     * @return $this
     * @throws Exception
     */
    public function setCodeGrade(string $CodeGrade): Pompier
    {
        if (!array_key_exists($CodeGrade, self::GRADES)) {
            throw new Exception("Le code de grade n'est pas valide !");
        }
        $this->CodeGrade = $CodeGrade;
        return $this;
    }

    /**
     * Return the name of the grade of the pompier
     * @return string
     */
    public function getGrade(): string
    {
        return self::GRADES[$this->CodeGrade];
    }

    /**
     * Return the matricule of the superior of the pompier
     * @return string|null
     */
    public function getMatriculeRespo(): ?string
    {
        return $this->MatriculeRespo;
    }


    /**
     * Set the matricule of the superior of the pompier
     * @param string|null $MatriculeRespo
     * @return $this
     * @throws Exception
     */
    public function setMatriculeRespo(?string $MatriculeRespo): Pompier
    {
        if ($MatriculeRespo !== null) {
            if (mb_strlen($MatriculeRespo) !== 7) {
                throw new Exception("Le matricule du resp. doit contenir exactement 7 caractères !");
            }
            if (!str_starts_with($MatriculeRespo, "Ma")) {
                throw new Exception("Le matricule du resp. doit commencer par 'Ma' !");
            }
            if (!ctype_digit(substr($MatriculeRespo, -5))) {
                throw new Exception("Les 5 derniers caractères du matricule du resp. doivent être des chiffres !");
            }
        }
        $this->MatriculeRespo = $MatriculeRespo;
        return $this;
    }
}
