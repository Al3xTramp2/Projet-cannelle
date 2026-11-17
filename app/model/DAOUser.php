<?php

namespace Supalta\Cannelle\model;

use Exception;
use PDO;

/**
 * Data access object of the users, uses the table User
 */
class DAOUser extends DAO
{
    private PDO $pdo;


    /**
     * Constructor of the DAOUser class
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct();
        $this->pdo = $pdo;
    }

    /**
     * Generate a new key for the User entity
     * @return int
     */
    private function keyGenerator(): int
    {
        $sql = "SELECT IdUser FROM user ORDER BY IdUser DESC LIMIT 1;";
        $last = $this->pdo->query($sql)->fetchColumn();

        if ($last === false) {
            return 1;
        }

        ++$last;

        return $last;
    }

    /**
     * Return an entity User according to the key $IdUser
     * @param int $IdUser
     * @return User|null
     */
    public function find(int $IdUser): ?User
    {
        $sql = "SELECT * FROM user WHERE IdUser = :IdUser AND Deleted = false;";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("IdUser", $IdUser, PDO::PARAM_INT);
        $preparedStatement->execute();
        $user = $preparedStatement->fetchObject(User::class);

        return $user ?: null;
    }

    /**
     * ave a User entity
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        $user->setIdUser($this->keyGenerator());

        $sql = "INSERT INTO user (IdUser, Login, PasswordHash, Nom, Prenom, Mail, Role, MatriculePompier)
                VALUES (:IdUser, :Login, :PasswordHash, :Nom, :Prenom, :Mail, :Role, :MatriculePompier);";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("IdUser", $user->getIdUser(), PDO::PARAM_INT);
        $preparedStatement->bindValue("Login", $user->getLogin(), PDO::PARAM_STR);
        $preparedStatement->bindValue("PasswordHash", $user->getPasswordHash(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Nom", $user->getNom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Prenom", $user->getPrenom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Mail", $user->getMail(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Role", $user->getRole(), PDO::PARAM_INT);

        $matricule = $user->getMatriculePompier();
        $type = $matricule === null
            ? PDO::PARAM_NULL
            : PDO::PARAM_STR;
        $preparedStatement->bindValue("MatriculePompier", $matricule, $type);

        return $preparedStatement->execute();
    }

    /**
     * Update a User entity
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public function update(User $user): bool
    {
        if ($this->find($user->getIdUser()) === null) {
            throw new Exception("Le user dont l'Id est " . $user->getIdUser() . " n'est pas définit !");
        }

        $sql = "UPDATE user SET Login = :Login, PasswordHash = :PasswordHash, Nom = :Nom, Prenom = :Prenom"
            . ", Mail = :Mail, Role = :Role, MatriculePompier = :MatriculePompier"
            . " WHERE IdUser = :IdUser AND Deleted = false;";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("IdUser", $user->getIdUser(), PDO::PARAM_INT);
        $preparedStatement->bindValue("Login", $user->getLogin(), PDO::PARAM_STR);
        $preparedStatement->bindValue("PasswordHash", $user->getPasswordHash(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Nom", $user->getNom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Prenom", $user->getPrenom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Mail", $user->getMail(), PDO::PARAM_STR);
        $preparedStatement->bindValue("Role", $user->getRole(), PDO::PARAM_INT);

        $matricule = $user->getMatriculePompier();
        $type = $matricule === null
            ? PDO::PARAM_NULL
            : PDO::PARAM_STR;
        $preparedStatement->bindValue("MatriculePompier", $matricule, $type);

        return $preparedStatement->execute();
    }

    /**
     * Delete a User entity
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public function delete(User $user): bool
    {
        if ($this->find($user->getIdUser()) === null) {
            throw new Exception("Le user portant dont l'Id est " . $user->getIdUser() . " n'est pas définit !");
        }

        $sql = "UPDATE user SET Deleted = true WHERE IdUser = :IdUser;";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("IdUser", $user->getIdUser(), PDO::PARAM_INT);

        return $preparedStatement->execute();
    }

    /**
     * Return all User entities, limited to 100 and starting from the first one by default
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function findAll(int $offset = 0, int $limit = 100): array
    {
        $sql = "SELECT * FROM user WHERE Deleted = FALSE ORDER BY IdUser LIMIT :offset, :limit;";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("offset", $offset, PDO::PARAM_INT);
        $preparedStatement->bindValue("limit", $limit, PDO::PARAM_INT);
        $preparedStatement->execute();

        return $preparedStatement->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    /**
     * Return the amout of Users
     * @return int
     */
    public function count(): int
    {
        $sql = "SELECT COUNT(*) FROM user WHERE Deleted = FALSE;";

        $count = $this->pdo->query($sql)->fetchColumn();

        return (int) $count;
    }

    /**
     * Return all the User entities caller $Nom
     * @param string $Nom
     * @return array
     */
    public function findByNom(string $Nom): array
    {
        $sql = "SELECT * FROM user WHERE Nom = :Nom AND Deleted = FALSE ORDER BY IdUser";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->bindValue("Nom", $Nom, PDO::PARAM_STR);
        $preparedStatement->execute();

        return $preparedStatement->fetchAll(PDO::FETCH_CLASS, User::class);
    }
}
