<?php

namespace Supalta\Cannelle\controller;

use Supalta\Cannelle\model\Caserne;
use Supalta\Cannelle\model\DAOCaserne;
use Supalta\Cannelle\utils\Renderer;
use Supalta\Cannelle\utils\SingletonDataBaseMariaDB;
use Exception;

/**
 * Controller of the Caserne: lists, shows, creates, updates and deletes them
 */
class CaserneController extends BaseController
{
    private DAOCaserne $daoCaserne;

    /**
     * Constructor of the CaserneController class
     */
    public function __construct()
    {
        parent::__construct();
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $this->daoCaserne = new DAOCaserne($pdo);
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
        echo Renderer::render('caserneCreate', compact('types'));
    }

    /**
     * Create the caserne from the form and display it
     * @return void
     * @throws Exception
     */
    public function doCreate(): void
    {
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
        echo Renderer::render('caserneUpdate', compact('caserne', 'types'));
    }

    /**
     * Update the caserne from the form and display it
     * @return void
     * @throws Exception
     */
    public function doUpdate(): void
    {
        $caserne = $this->daoCaserne->find((int) $_POST['numCaserne']);
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
        echo Renderer::render('caserneDelete', compact('caserne'));
    }

    /**
     * Delete the caserne and redirect to the list
     * @return void
     * @throws Exception
     */
    public function doDelete(): void
    {
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
