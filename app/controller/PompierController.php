<?php

namespace Supalta\Cannelle\controller;

use Supalta\Cannelle\model\DAOCaserne;
use Supalta\Cannelle\model\DAOPompier;
use Supalta\Cannelle\model\Pompier;
use Supalta\Cannelle\utils\Filtre;
use Supalta\Cannelle\utils\Renderer;
use Supalta\Cannelle\utils\validators\DateNaissanceValidator;
use Supalta\Cannelle\utils\SingletonDataBaseMariaDB;
use Supalta\Cannelle\utils\CSRF\CSRFCookie;
use DateTime;
use Exception;

/**
 * Controller of the pompiers: lists, shows, creates, updates and deletes them
 */
class PompierController extends BaseController
{
    private DAOPompier $daoPompier;
    private DAOCaserne $daoCaserne;
    private Filtre $filtre;

    /**
     * Constructor of the PompierController class
     */
    public function __construct()
    {
        parent::__construct();
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $this->daoPompier = new DAOPompier($pdo);
        $this->daoCaserne = new DAOCaserne($pdo);
        $this->filtre = new Filtre();
        $this->filtre->accept("dateNaissance", new DateNaissanceValidator());
    }

    /**
     * Display the list of all the pompiers
     * @return void
     * @throws Exception
     */
    public function show(): void
    {
        $villes = [];
        foreach ($this->daoCaserne->findAll(0, 1000) as $caserne) {
            $villes[$caserne->getNumCaserne()] = $caserne->getVille();
        }
        $pompiers = $this->daoPompier->findAll(0, 1000);
        $total = count($pompiers);
        $grades = Pompier::GRADES;
        echo Renderer::render("pompierListe", compact('pompiers', 'villes', 'total', 'grades'));
    }

    /**
     * Display the details of one pompier
     * @return void
     * @throws Exception
     */
    public function detail(): void
    {
        $pompier = $this->daoPompier->find($_GET['matricule']);
        echo Renderer::render("pompierDetail", compact('pompier'));
    }

    /**
     * Display the form to create a pompier
     * @return void
     * @throws Exception
     */
    public function create(): void
    {
        $casernes = $this->daoCaserne->findAll();
        $grades = Pompier::GRADES;
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render("pompierCreate", compact('casernes', 'grades', 'csrfToken'));
    }

    /**
     * Create the pompier from the form and display it
     * @return void
     * @throws Exception
     */
    public function doCreate(): void
    {
        $csrfToken = $_POST['csrf_token'] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $resultat = $this->filtre->visit($_POST);
        if (!$resultat["dateNaissance"]) {
            $casernes = $this->daoCaserne->findAll();
            $grades = Pompier::GRADES;
            $erreur = true;
            echo Renderer::render("pompierCreate", compact('casernes', 'grades', 'erreur', 'csrfToken'));
            return;
        }

        $pompier = (new Pompier())
            ->setPrenom($_POST['prenom'])
            ->setNom($_POST['nom'])
            ->setChefAgret($_POST['chefAgret'])
            ->setDateNaissance(new DateTime($_POST['dateNaissance']))
            ->setNumCaserne($_POST['numCaserne'])
            ->setCodeGrade($_POST['codeGrade'])
            ->setMatriculeRespo($_POST['matriculeRespo']);
        $this->daoPompier->save($pompier);
        header("Location: /pompier/detail?matricule=" . $pompier->getMatricule());
    }

    /**
     * Display the form to update a pompier
     * @return void
     * @throws Exception
     */
    public function update(): void
    {
        $pompier = $this->daoPompier->find($_GET['matricule']);
        $casernes = $this->daoCaserne->findAll();
        $grades = Pompier::GRADES;
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render("pompierUpdate", compact('pompier', 'casernes', 'grades', 'csrfToken'));
    }

    /**
     * Update the pompier from the form and display it
     * @return void
     * @throws Exception
     */
    public function doUpdate(): void
    {
        $csrfToken = $_POST['csrf_token'] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $pompier = $this->daoPompier->find($_POST['matricule']);

        $resultat = $this->filtre->visit($_POST);
        if (!$resultat["dateNaissance"]) {
            $casernes = $this->daoCaserne->findAll();
            $grades = Pompier::GRADES;
            $erreur = true;
            echo Renderer::render("pompierUpdate", compact('pompier', 'casernes', 'grades', 'erreur', 'csrfToken'));
            return;
        }

        $pompier->setPrenom($_POST['prenom'])
            ->setNom($_POST['nom'])
            ->setChefAgret($_POST['chefAgret'])
            ->setDateNaissance(new DateTime($_POST['dateNaissance']))
            ->setNumCaserne($_POST['numCaserne'])
            ->setCodeGrade($_POST['codeGrade'])
            ->setMatriculeRespo($_POST['matriculeRespo']);
        $this->daoPompier->update($pompier);
        header("Location: /pompier/detail?matricule=" . $pompier->getMatricule());
    }

    /**
     * Display the confirmation page before deleting a pompier
     * @return void
     * @throws Exception
     */
    public function delete(): void
    {
        $pompier = $this->daoPompier->find($_GET['matricule']);
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render("pompierDelete", compact('pompier', 'csrfToken'));
    }

    /**
     * Delete the pompier and redirect to the list
     * @return void
     * @throws Exception
     */
    public function doDelete(): void
    {
        $csrfToken = $_POST['csrf_token'] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $pompier = $this->daoPompier->find($_POST['matricule']);
        $this->daoPompier->delete($pompier);
        header('Location: /pompier/liste');
    }

    /**
     * Display the pompiers having the given name
     * @return void
     * @throws Exception
     */
    public function showByName(): void
    {
        $villes = [];
        foreach ($this->daoCaserne->findAll(0, 1000) as $caserne) {
            $villes[$caserne->getNumCaserne()] = $caserne->getVille();
        }
        $pompiers = $this->daoPompier->findByName($_GET['nom']);
        $total = count($pompiers);
        $grades = Pompier::GRADES;
        echo Renderer::render("pompierListe", compact('pompiers', 'villes', 'total', 'grades'));
    }
}
