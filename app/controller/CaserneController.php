<?php

namespace Supalta\Cannelle\controller;

use Supalta\Cannelle\model\Caserne;
use Supalta\Cannelle\model\DAOCaserne;
use Supalta\Cannelle\utils\Filtre;
use Supalta\Cannelle\utils\Renderer;
use Supalta\Cannelle\utils\validators\CodePostalValidator;
use Supalta\Cannelle\utils\SingletonDataBaseMariaDB;
use Supalta\Cannelle\utils\CSRF\CSRFCookie;
use Exception;

/**
 * Controller of the Caserne: lists, shows, creates, updates and deletes them
 */
class CaserneController extends BaseController
{
    private DAOCaserne $daoCaserne;
    private Filtre $filtre;

    /**
     * Constructor of the CaserneController class
     */
    public function __construct()
    {
        parent::__construct();
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $this->daoCaserne = new DAOCaserne($pdo);
        $this->filtre = new Filtre();
        $this->filtre->accept("cp", new CodePostalValidator());
    }

    /**
     * Display the list of all the casernes
     * @return void
     * @throws Exception
     */
    public function show(): void
    {
        $casernes = $this->daoCaserne->findAll(0, 1000);
        $total = count($casernes);
        echo Renderer::render('caserneListe', compact('casernes', 'total'));
    }

    /**
     * Display the details of one caserne
     * @return void
     * @throws Exception
     */
    public function detail(): void
    {
        $caserne = $this->daoCaserne->find((int) $_GET['numCaserne']);
        echo Renderer::render('caserneDetail', compact('caserne'));
    }

    /**
     * Display the form to create a caserne
     * @return void
     * @throws Exception
     */
    public function create(): void
    {
        $types = Caserne::TYPES;
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render('caserneCreate', compact('types', "csrfToken"));
    }

    /**
     * Create the caserne from the form and display it
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
        if (!$resultat["cp"]) {
            $types = Caserne::TYPES;
            $erreur = true;
            echo Renderer::render('caserneCreate', compact('types', 'erreur', 'csrfToken'));
            return;
        }

        $caserne = (new Caserne())
            ->setAdresse($_POST['adresse'])
            ->setCP($_POST['cp'])
            ->setVille($_POST['ville'])
            ->setCodeTypeC($_POST['codeTypeC']);
        $this->daoCaserne->save($caserne);
        header("Location: /caserne/detail?numCaserne=" . $caserne->getNumCaserne());
    }

    /**
     * Display the form to update a caserne
     * @return void
     * @throws Exception
     */
    public function update(): void
    {
        $caserne = $this->daoCaserne->find((int) $_GET['numCaserne']);
        $types = Caserne::TYPES;
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render('caserneUpdate', compact('caserne', 'types', "csrfToken"));
    }

    /**
     * Update the caserne from the form and display it
     * @return void
     * @throws Exception
     */
    public function doUpdate(): void
    {

        $csrfToken = $_POST["csrf_token"] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $caserne = $this->daoCaserne->find((int) $_POST['numCaserne']);

        $resultat = $this->filtre->visit($_POST);
        if (!$resultat["cp"]) {
            $types = Caserne::TYPES;
            $erreur = true;
            echo Renderer::render('caserneUpdate', compact('caserne', 'types', 'erreur', 'csrfToken'));
            return;
        }

        $caserne->setAdresse($_POST['adresse'])
            ->setCP($_POST['cp'])
            ->setVille($_POST['ville'])
            ->setCodeTypeC($_POST['codeTypeC']);
        $this->daoCaserne->update($caserne);
        header("Location : /caserne/detail?numCaserne=" . $caserne->getNumCaserne());
    }

    /**
     * Display the confirmation page before deleting a caserne
     * @return void
     * @throws Exception
     */
    public function delete(): void
    {
        $caserne = $this->daoCaserne->find((int) $_GET['numCaserne']);
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render('caserneDelete', compact('caserne', 'csrfToken'));
    }

    /**
     * Delete the caserne and redirect to the list
     * @return void
     * @throws Exception
     */
    public function doDelete(): void
    {
        $csrfToken = $_POST["csrf_token"] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $caserne = $this->daoCaserne->find((int) $_POST['numCaserne']);
        $this->daoCaserne->delete($caserne);
        header('Location: /caserne/liste');
    }

    /**
     * Display the casernes located in the given city
     * @return void
     * @throws Exception
     */
    public function showByVille(): void
    {
        $casernes = $this->daoCaserne->findByVille($_GET['ville']);
        $total = count($casernes);
        echo Renderer::render('caserneListe', compact('casernes', 'total'));
    }
}
