<?php

namespace Supalta\Cannelle\utils;

use Exception;
use Supalta\Cannelle\model\DAOUser;
use Supalta\Cannelle\model\User;

class Auth
{
    private const array PRIVILEGES = [
        'Pompier' => 1 + 256,
        'Responsable de Caserne' => 1 + 2 + 256 + 512,
        'Secretaire' => 1 + 2 + 8 + 256 + 512 + 2048 + 65536,
        'Admin' => 2039583,
    ];

    private const array DROITS = [
        'caserne' => ['read' => 1, 'detail' => 2, 'create' => 4, 'update' => 8, 'delete' => 16],
        'pompier' => ['read' => 256, 'detail' => 512, 'create' => 1024, 'update' => 2048, 'delete' => 4096],
        'user' => ['read' => 65536, 'detail' => 131072, 'create' => 262144, 'update' => 524288, 'delete' => 1048576],
    ];

    /**
     * Check if user exist in DB with is login
     * @param string $log
     * @param string $password
     * @return User|null
     * @throws Exception
     */
    public static function login(string $log, string $password): ?User
    {
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $daoUser = new DAOUser($pdo);
        $user = $daoUser->findByLogin($log);

        if ($user === null || !password_verify($password, $user->getPasswordHash())) {
            SingletonLogger::getInstance()
                ->getAccessLogger()
                ->warning('Connexion échouée', ['login' => $log]);
            return null;
        }
        if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
            throw new Exception("Impossible de démarrer la session.");
        }
        if (!session_regenerate_id(true)) {
            throw new Exception("Impossible de renouveler la session.");
        }

        $_SESSION['auth']['idUser'] = $user->getIdUser();
        $_SESSION['auth']['role'] = $user->getRoleName();

        SingletonLogger::getInstance()
            ->getAccessLogger()
            ->info('Connexion réussie', ['idUser' => $user->getIdUser()]);
        return $user;
    }

    /**
     * @return void
     */
    public static function logout(): void
    {
        if (!self::isLogged()) {
            return;
        }

        $idUser = $_SESSION['auth']['idUser'];
        unset($_SESSION['auth']);

        SingletonLogger::getInstance()
            ->getAccessLogger()
            ->info('Déconnexion réussie', ['idUser' => $idUser]);
    }

    /**
     * Check if the user is logged (based on session information)
     * @return bool
     */
    public static function isLogged(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
            return false;
        }

        return isset($_SESSION['auth']['idUser']);
    }

    /**
     * Return the id of the logged user, or 0
     * @return int
     */
    public static function getIdUser(): int
    {
        if (!self::isLogged()) {
            return 0;
        }

        return $_SESSION['auth']['idUser'];
    }

    /**
     * Return the role name of the logged user, or an empty string
     * @return string
     */
    public static function getRole(): string
    {
        if (!self::isLogged()) {
            return '';
        }

        return $_SESSION['auth']['role'];
    }

    /**
     * Return true if the role of the logged user allows the action on the table
     * @param string $table
     * @param string $perm
     * @return bool
     */
    public static function can(string $table, string $perm): bool
    {
        $droitDemande = self::DROITS[$table][$perm] ?? null;
        if ($droitDemande === null) {
            return false;
        }

        $privileges = self::PRIVILEGES[self::getRole()] ?? 0;

        return ($privileges & $droitDemande) === $droitDemande;
    }
}
