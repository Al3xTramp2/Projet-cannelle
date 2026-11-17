<?php

namespace Supalta\Cannelle\model;

use InvalidArgumentException;

class User extends \stdClass
{
    /**
     * Maps role codes to their display names.
     */
    public const array ROLE = [
        "1" => "Admin",
        "2" => "Secretaire",
        "3" => "Responsable de Caserne",
        "4" => "Pompier"
    ];

    private int $IdUser;
    private string $Login;
    private string $PasswordHash;
    private string $Nom;
    private string $Prenom;
    private string $Mail;
    private ?string $MatriculePompier = null;
    private int $Role;

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->IdUser;
    }

    /**
     * @param int $IdUser
     * @return $this
     */
    public function setIdUser(int $IdUser): self
    {
        if ($IdUser <= 0) {
            throw new InvalidArgumentException("Le numéro du user doit être positif strictement");
        }
        $this->IdUser = $IdUser;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->Login;
    }

    /**
     * @param string $Login
     * @return $this
     */
    public function setLogin(string $Login): self
    {
        $this->Login = $Login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->PasswordHash;
    }

    /**
     * @param string $PasswordHash
     * @return $this
     */
    public function setPasswordHash(string $PasswordHash): self
    {
        $this->PasswordHash = $PasswordHash;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->Nom;
    }

    /**
     * @param string $Nom
     * @return $this
     */
    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;
            return $this;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->Prenom;
    }

    /**
     * @param string $Prenom
     * @return $this
     */
    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->Mail;
    }

    /**
     * @param string $Mail
     * @return $this
     */
    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;
        return $this;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->Role;
    }

    /**
     * Returns the display name of the user's role from its code.
     * @return string
     */
    public function getRoleName(): string
    {
        return self::ROLE[$this->Role];
    }

    /**
     * @param int $Role
     * @return $this
     */
    public function setRole(int $Role): self
    {
        if (!array_key_exists($Role, self::ROLE)) {
            throw new InvalidArgumentException("Ce rôle n'est pas définit");
        }
        $this->Role = $Role;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMatriculePompier(): ?string
    {
        return $this->MatriculePompier;
    }

    /**
     * @param string|null $MatriculePompier
     * @return $this
     */
    public function setMatriculePompier(?string $MatriculePompier): self
    {
        $this->MatriculePompier = $MatriculePompier;
        return $this;
    }
}
