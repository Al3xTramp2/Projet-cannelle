<?php

namespace Supalta\Cannelle\model;

use Exception;
use PDO;

class DAOCaserne extends DAO
{
    private PDO $pdo;

    /**
     * Geenerate a new key for the Caserne entity
     * @return int
     */
    private function keyGenerator(): int
    {
        $sql = "SELECT NumCaserne FROM casernes ORDER BY NumCaserne DESC LIMIT 1;";
        $last = $this->pdo->query($sql)->fetchColumn();

        if ($last === false) {
            return 1;
        }

        ++$last;

        return $last;
    }

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct();
        $this->pdo = $pdo;
    }

    /**
     * Return an entity Caserne according to the key $id
     * @param int $id
     * @return Caserne|null
     */
    public function find(int $id): ?Caserne
    {
        $sql = "SELECT * FROM casernes WHERE NumCaserne = :NumCaserne";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("NumCaserne", $id, PDO::PARAM_INT);
        $preparedStatement->execute();
        $caserne = $preparedStatement->fetchObject(Caserne::class);

        return $caserne ?: null;
    }

    /**
     * Save a Caserne entity
     * @param Caserne $caserne
     * @return bool
     * @throws Exception
     */
    public function save(Caserne $caserne): bool
    {
        $caserne->setNumCaserne($this->keyGenerator());

        $sql = "INSERT INTO casernes (NumCaserne, Adresse, CP, Ville, CodeTypeC) 
                VALUES (:NumCaserne, :Adresse, :CP, :Ville, :CodeTypeC)";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("NumCaserne", $caserne->getNumCaserne(), PDO::PARAM_INT);
        $preparedStatement->bindValue("Adresse", $caserne->getAdresse(), PDO::PARAM_STR);
        $preparedStatement->bindValue("CP", $caserne->getCP(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Ville", $caserne->getVille(), PDO::PARAM_STR);
        $preparedStatement->bindValue("CodeTypeC", $caserne->getCodeTypeC(), PDO::PARAM_INT);

        return $preparedStatement->execute();
    }

    /**
     * Update the Caserne entity
     * @param Caserne $caserne
     * @return bool
     * @throws Exception if the Caserne does not exist
     */
    public function update(Caserne $caserne): bool
    {
        if ($this->find($caserne->getNumCaserne()) === null) {
            throw new Exception("La caserne portant le numéro " . $caserne->getNumCaserne() . " n'existe pas !");
        }

        $sql = "UPDATE casernes SET Adresse = :Adresse, CP = :CP, Ville = :Ville, CodeTypeC = :CodeTypeC"
             . "WHERE NumCaserne = :NumCaserne";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("NumCaserne", $caserne->getNumCaserne(), PDO::PARAM_INT);
        $preparedStatement->bindValue("Adresse", $caserne->getAdresse(), PDO::PARAM_STR);
        $preparedStatement->bindValue("CP", $caserne->getCP(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Ville", $caserne->getVille(), PDO::PARAM_STR);
        $preparedStatement->bindValue("CodeTypeC", $caserne->getCodeTypeC(), PDO::PARAM_INT);

        return $preparedStatement->execute();
    }

    /**
     * Delete the Caserne entity
     * @param Caserne $caserne
     * @return bool
     * @throws Exception
     */
    public function delete(Caserne $caserne): bool
    {
        if ($this->find($caserne->getNumCaserne()) === null) {
            throw new Exception("La caserne portant le numéro " . $caserne->getNumCaserne() . " n'existe pas !");
        }

        $sql = "DELETE FROM casernes WHERE NumCaserne = :NumCaserne";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("NumCaserne", $caserne->getNumCaserne(), PDO::PARAM_INT);
        $preparedStatement->execute();

        return $preparedStatement->rowCount() > 0;
    }

    /**
     * Return all Caserne entities, limited to 100 and starting from the first one by default
     * @param int $offset
     * @param int $limit
     * @return Caserne[]
     */
    public function findAll(int $offset = 0, int $limit = 100): array
    {
        $sql = "SELECT * FROM casernes ORDER BY NumCaserne LIMIT :offset, :limit";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("offset", $offset, PDO::PARAM_INT);
        $preparedStatement->bindValue("limit", $limit, PDO::PARAM_INT);
        $preparedStatement->execute();

        $caserneList = $preparedStatement->fetchAll(PDO::FETCH_CLASS, Caserne::class);

        return $caserneList;
    }

    /**
     * Return the amount of Casernes
     * @return int
     */
    public function count(): int
    {
        $sql = "SELECT COUNT(*) FROM casernes";

        $count = $this->pdo->query($sql)->fetchColumn();

        return (int) $count;
    }

    /**
     * Return all the Caserne entities located in this exact city
     * @param string $ville
     * @return Caserne[]
     */
    public function findByVille(string $ville): array
    {
        $sql = "SELECT * FROM casernes WHERE Ville = :Ville ORDER BY NumCaserne";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("Ville", $ville, PDO::PARAM_STR);
        $preparedStatement->execute();

        $caserneList = $preparedStatement->fetchAll(PDO::FETCH_CLASS, Caserne::class);

        return $caserneList;
    }
}
