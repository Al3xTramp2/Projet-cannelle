<?php

namespace Supalta\Cannelle\controller;

use Exception;
use Supalta\Cannelle\model\DAOUser;
use Supalta\Cannelle\model\User;
use Supalta\Cannelle\utils\Auth;
use Supalta\Cannelle\utils\Filtre;
use Supalta\Cannelle\utils\Renderer;
use Supalta\Cannelle\utils\SingletonDataBaseMariaDB;
use Supalta\Cannelle\utils\SingletonLogger;
use Supalta\Cannelle\utils\validators\CSRF\CSRFCookie;
use Supalta\Cannelle\utils\validators\PasswordValidator;

/**
 * Controller of the account of the logged user: change of password
 */
class AccountController extends BaseController
{
    // A new password must differ from the current one and from the previous ones, 6 passwords in total
    private const int HISTORY_SIZE = 6;

    private DAOUser $daoUser;
    private Filtre $filtre;

    /**
     * Constructor of the AccountController class
     */
    public function __construct()
    {
        parent::__construct();
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $this->daoUser = new DAOUser($pdo);
        $this->filtre = new Filtre();
        $this->filtre->accept("newPassword", new PasswordValidator());
    }

    /**
     * Display the form to change the password
     * @return void
     * @throws Exception
     */
    public function password(): void
    {
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render("accountPassword", compact('csrfToken'));
    }

    /**
     * Change the password of the logged user from the form
     * @return void
     * @throws Exception
     */
    public function doPassword(): void
    {
        $csrfToken = $_POST['csrf_token'] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $user = $this->daoUser->find(Auth::getIdUser());
        $newPassword = $_POST['newPassword'] ?? '';
        $resultat = $this->filtre->visit($_POST);

        $erreur = '';
        if (!password_verify($_POST['oldPassword'] ?? '', $user->getPasswordHash())) {
            $erreur = "Ancien mot de passe incorrect.";
            SingletonLogger::getInstance()
                ->getAccessLogger()
                ->warning('Changement de mot de passe refusé', ['idUser' => $user->getIdUser()]);
        } elseif ($newPassword !== ($_POST['confirmPassword'] ?? '')) {
            $erreur = "La confirmation ne correspond pas au nouveau mot de passe.";
        } elseif (!$resultat["newPassword"]) {
            $erreur = "Mot de passe trop faible (plus de 12 caractères, une majuscule, une minuscule, "
                . "un chiffre et un symbole).";
        } elseif ($this->isUsed($user, $newPassword)) {
            $erreur = "Ce mot de passe a déjà été utilisé récemment.";
        }

        $csrfToken = CSRFCookie::generateToken();
        if ($erreur !== '') {
            echo Renderer::render("accountPassword", compact('erreur', 'csrfToken'));
            return;
        }

        $this->daoUser->addPasswordHistory($user->getIdUser(), $user->getPasswordHash());
        $user->setPasswordHash(password_hash($newPassword, PASSWORD_DEFAULT));
        $this->daoUser->update($user);
        SingletonLogger::getInstance()
            ->getAccessLogger()
            ->info('Mot de passe modifié', ['idUser' => $user->getIdUser()]);

        $succes = true;
        echo Renderer::render("accountPassword", compact('succes', 'csrfToken'));
    }

    /**
     * Return true if the password is the current one or one of the previous ones
     * @param User $user
     * @param string $password
     * @return bool
     */
    private function isUsed(User $user, string $password): bool
    {
        $hashes = $this->daoUser->findPasswordHistory($user->getIdUser(), self::HISTORY_SIZE - 1);
        $hashes[] = $user->getPasswordHash();
        foreach ($hashes as $hash) {
            if (password_verify($password, $hash)) {
                return true;
            }
        }
        return false;
    }
}
