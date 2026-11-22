<?php

namespace Supalta\Cannelle\controller;

use Exception;
use PDOException;
use Supalta\Cannelle\model\DAOPompier;
use Supalta\Cannelle\model\DAOUser;
use Supalta\Cannelle\model\User;
use Supalta\Cannelle\utils\Filtre;
use Supalta\Cannelle\utils\Renderer;
use Supalta\Cannelle\utils\SingletonDataBaseMariaDB;
use Supalta\Cannelle\utils\validators\CSRF\CSRFCookie;
use Supalta\Cannelle\utils\validators\MailValidator;
use Supalta\Cannelle\utils\validators\PasswordValidator;

/**
 * Controller of the users: lists, shows, creates, updates and deletes them
 */
class UserController extends BaseController
{
    private DAOUser $daoUser;
    private DAOPompier $daoPompier;
    private Filtre $filtre;

    /**
     * Constructor of the UserController class
     */
    public function __construct()
    {
        parent::__construct();
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $this->daoUser = new DAOUser($pdo);
        $this->daoPompier = new DAOPompier($pdo);
        $this->filtre = new Filtre();
        $this->filtre->accept("mail", new MailValidator());
        $this->filtre->accept("password", new PasswordValidator());
    }

    /**
     * Display the list of all the users
     * @return void
     * @throws Exception
     */
    public function show(): void
    {
        if (!$this->allow('user', 'read')) {
            return;
        }

        $users = $this->daoUser->findAll(0, 1000);
        $total = count($users);
        echo Renderer::render("userListe", compact('users', 'total'));
    }

    /**
     * Display the details of one user
     * @return void
     * @throws Exception
     */
    public function detail(): void
    {
        if (!$this->allow('user', 'detail')) {
            return;
        }

        $user = $this->daoUser->find((int) $_GET['idUser']);
        echo Renderer::render("userDetail", compact('user'));
    }

    /**
     * Display the form to create a user
     * @return void
     * @throws Exception
     */
    public function create(): void
    {
        if (!$this->allow('user', 'create')) {
            return;
        }

        $old = [];
        $roles = User::ROLE;
        $pompiers = $this->daoPompier->findAll(0, 1000);
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render("userCreate", compact('old', 'roles', 'pompiers', 'csrfToken'));
    }

    /**
     * Create the user from the form and display it
     * @return void
     * @throws Exception
     */
    public function doCreate(): void
    {
        if (!$this->allow('user', 'create')) {
            return;
        }

        $csrfToken = $_POST['csrf_token'] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $matricule = $_POST['matriculePompier'] === '' ? null : $_POST['matriculePompier'];
        $user = (new User())
            ->setLogin($_POST['login'])
            ->setPasswordHash(password_hash($_POST['password'], PASSWORD_DEFAULT))
            ->setNom($_POST['nom'])
            ->setPrenom($_POST['prenom'])
            ->setMail($_POST['mail'])
            ->setRole((int) $_POST['role'])
            ->setMatriculePompier($matricule);

        $resultat = $this->filtre->visit($_POST);
        $erreur = '';
        if (!$resultat["mail"]) {
            $erreur = "Adresse mail invalide.";
        } elseif (!$resultat["password"]) {
            $erreur = "Mot de passe trop faible (plus de 12 caractères, une majuscule, une minuscule, "
                . "un chiffre et un symbole).";
        } else {
            try {
                $this->daoUser->save($user);
            } catch (PDOException $e) {
                $erreur = "Login, mail ou pompier déjà utilisé.";
            }
        }

        if ($erreur !== '') {
            $old = $_POST;
            $roles = User::ROLE;
            $pompiers = $this->daoPompier->findAll(0, 1000);
            $csrfToken = CSRFCookie::generateToken();
            echo Renderer::render("userCreate", compact('old', 'roles', 'pompiers', 'erreur', 'csrfToken'));
            return;
        }

        header("Location: /user/detail?idUser=" . $user->getIdUser());
    }

    /**
     * Display the form to update a user
     * @return void
     * @throws Exception
     */
    public function update(): void
    {
        if (!$this->allow('user', 'update')) {
            return;
        }

        $user = $this->daoUser->find((int) $_GET['idUser']);
        $roles = User::ROLE;
        $pompiers = $this->daoPompier->findAll(0, 1000);
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render("userUpdate", compact('user', 'roles', 'pompiers', 'csrfToken'));
    }

    /**
     * Update the user from the form and display it
     * @return void
     * @throws Exception
     */
    public function doUpdate(): void
    {
        if (!$this->allow('user', 'update')) {
            return;
        }

        $csrfToken = $_POST['csrf_token'] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $matricule = $_POST['matriculePompier'] === '' ? null : $_POST['matriculePompier'];
        $user = $this->daoUser->find((int) $_POST['idUser']);
        $user->setLogin($_POST['login'])
            ->setNom($_POST['nom'])
            ->setPrenom($_POST['prenom'])
            ->setMail($_POST['mail'])
            ->setRole((int) $_POST['role'])
            ->setMatriculePompier($matricule);

        $resultat = $this->filtre->visit($_POST);
        $erreur = '';
        if (!$resultat["mail"]) {
            $erreur = "Adresse mail invalide.";
        } else {
            try {
                $this->daoUser->update($user);
            } catch (PDOException $e) {
                $erreur = "Login, mail ou pompier déjà utilisé.";
            }
        }

        if ($erreur !== '') {
            $roles = User::ROLE;
            $pompiers = $this->daoPompier->findAll(0, 1000);
            $csrfToken = CSRFCookie::generateToken();
            echo Renderer::render("userUpdate", compact('user', 'roles', 'pompiers', 'erreur', 'csrfToken'));
            return;
        }

        header("Location: /user/detail?idUser=" . $user->getIdUser());
    }

    /**
     * Display the confirmation page before deleting a user
     * @return void
     * @throws Exception
     */
    public function delete(): void
    {
        if (!$this->allow('user', 'delete')) {
            return;
        }

        $user = $this->daoUser->find((int) $_GET['idUser']);
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render("userDelete", compact('user', 'csrfToken'));
    }

    /**
     * Delete the user and redirect to the list
     * @return void
     * @throws Exception
     */
    public function doDelete(): void
    {
        if (!$this->allow('user', 'delete')) {
            return;
        }

        $csrfToken = $_POST['csrf_token'] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $user = $this->daoUser->find((int) $_POST['idUser']);
        $this->daoUser->delete($user);
        header('Location: /user/liste');
    }
}
