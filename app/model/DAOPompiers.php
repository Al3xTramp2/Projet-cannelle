<?php

namespace Supalta\Cannelle\model;

use PDO;

class DAOPompiers extends DAO
{
    private \PDO $pdo;

    /**
     * Generate a unique key for the Pompier entity
     * @return string
     */
    private function keyGenerator(): string {
        $sql = "SELECT Matricule FROM pompiers ORDER BY Matricule DESC LIMIT 1;";
        $last = $this->pdo->query($sql)->fetchColumn();

        if ($last === false) {
            return "Ma00001";
        }

        $number = (int)substr($last, -5);
        $number = $number + 1;
        $zLeft = 5 - mb_strlen($number);

        if ($zLeft < 0) {
            throw new \Exception("La limite de matricule a été atteinte !");
        }

        return "Ma" . str_repeat("0", $zLeft) . $number;
    }

    public function __construct( \PDO $pdo) {
        parent::__construct();
        $this->pdo = $pdo;
    }

    /**
     * Return an entity Pompier according to the key $id
     * @param string $matricule
     * @return Pompier|null
     */
    public function find(string $matricule): ?Pompier {
        $sql = "SELECT * FROM pompiers WHERE Matricule = :Matricule";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement -> bindValue("Matricule", $matricule, PDO::PARAM_STR);
        $preparedStatement->execute();
        $pompier = $preparedStatement->fetchObject(Pompier::class);

        return $pompier ?: null;
    }

    /**
     * Save a Pompier entity
     * @param Pompier $pompier
     * @return bool
     */
    public function save(Pompier $pompier) : bool {
        $pompier->setMatricule($this->keyGenerator());

        $sql = "INSERT INTO pompiers (Matricule, Prenom, Nom, ChefAgret, DateNaissance, NumCaserne, CodeGrade, MatriculeRespo) VALUES (:Matricule, :Prenom, :Nom, :ChefAgret, :DateNaissance, :NumCaserne, :CodeGrade, :MatriculeRespo)";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("Matricule", $pompier->getMatricule(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Prenom", $pompier->getPrenom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Nom", $pompier->getNom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("ChefAgret", $pompier->getChefAgret(), PDO::PARAM_STR);
        $preparedStatement->bindValue("DateNaissance", $pompier->getDateNaissance(), PDO::PARAM_STR);
        $preparedStatement->bindValue("NumCaserne", $pompier->getNumCaserne(), PDO::PARAM_INT);
        $preparedStatement->bindValue("CodeGrade", $pompier->getCodeGrade(), PDO::PARAM_STR);
        $preparedStatement->bindValue("MatriculeRespo", $pompier->getMatriculeRespo(), PDO::PARAM_STR);

        return $preparedStatement->execute();
    }

    /**
     * Update the Pompier entity
     * @param Pompier $pompier
     * @return bool
     */
    public function update(Pompier $pompier) : bool {
        if ($this->find($pompier->getMatricule()) === null) {
            throw new \Exception("Le pompier " . $pompier->getMatricule() . " n'existe pas !");
        }

        $sql = "UPDATE pompiers SET Prenom = :Prenom, Nom = :Nom, ChefAgret = :ChefAgret, DateNaissance = :DateNaissance, NumCaserne = :NumCaserne, CodeGrade = :CodeGrade, MatriculeRespo = :MatriculeRespo WHERE Matricule = :Matricule";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("Matricule", $pompier->getMatricule(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Prenom", $pompier->getPrenom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Nom", $pompier->getNom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("ChefAgret", $pompier->getChefAgret(), PDO::PARAM_STR);
        $preparedStatement->bindValue("DateNaissance", $pompier->getDateNaissance(), PDO::PARAM_STR);
        $preparedStatement->bindValue("NumCaserne", $pompier->getNumCaserne(), PDO::PARAM_INT);
        $preparedStatement->bindValue("CodeGrade", $pompier->getCodeGrade(), PDO::PARAM_STR);
        $preparedStatement->bindValue("MatriculeRespo", $pompier->getMatriculeRespo(), PDO::PARAM_STR);

        return $preparedStatement->execute();
    }

    /**
     * Delete the Pompier entity
     * @param Pompier $pompier
     * @return bool
     */
    public function delete(Pompier $pompier) : bool {
        $sql = "DELETE FROM pompiers WHERE Matricule = :Matricule";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("Matricule", $pompier->getMatricule(), PDO::PARAM_STR);
        $preparedStatement->execute();

        return $preparedStatement->rowCount() > 0;
    }

    /**
     * Return all the Pompier entities with a limit of 100 by default
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function findAll(int $offset = 0, int $limit = 100): array {
        $sql = "SELECT * FROM pompiers ORDER BY Matricule LIMIT :offset, :limit";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("offset", $offset, PDO::PARAM_INT);
        $preparedStatement->bindValue("limit", $limit, PDO::PARAM_INT);
        $preparedStatement->execute();

        $pompierList = $preparedStatement->fetchAll(PDO::FETCH_CLASS, Pompier::class);
        return $pompierList;
    }

    /**
     * @return int
     */
    public function count(): int {
        $sql = "SELECT COUNT(*) FROM pompiers";

        $count = $this->pdo->query($sql)->fetchColumn();

        return (int)$count;
    }

    /**
     * Return all the Pompier entities with a name
     * @param string $name
     * @return array
     */
    public function findByName(string $name): array {
        $sql = "SELECT * FROM pompiers WHERE Nom = :Name";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("Name", $name, PDO::PARAM_STR);
        $preparedStatement->execute();

        $pompierList = $preparedStatement->fetchAll(PDO::FETCH_CLASS, Pompier::class);
        return $pompierList;
    }

}
