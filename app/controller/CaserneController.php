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
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function detail(string $data): void
    {
        $caserne = $this->daoCaserne->find((int) $data);
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
     * @param array<string, mixed> $data
     * @return void
     * @throws Exception
     */
    public function doCreate(array $data): void
    {
        $caserne = (new Caserne())
            ->setAdresse($data['adresse'])
            ->setCP($data['cp'])
            ->setVille($data['ville'])
            ->setCodeTypeC($data['codeTypeC']);
        $this->daoCaserne->save($caserne);
        $this->detail((string) $caserne->getNumCaserne());
    }

    /**
     * Display the form to update a caserne
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function update(string $data): void
    {
        $caserne = $this->daoCaserne->find((int) $data);
        $types = Caserne::TYPES;
        echo Renderer::render('caserneUpdate', compact('caserne', 'types'));
    }

    /**
     * Update the caserne from the form and display it
     * @param array<string, mixed> $data
     * @return void
     * @throws Exception
     */
    public function doUpdate(array $data): void
    {
        $caserne = $this->daoCaserne->find((int) $data['numCaserne']);
        $caserne->setAdresse($data['adresse'])
            ->setCP($data['cp'])
            ->setVille($data['ville'])
            ->setCodeTypeC($data['codeTypeC']);
        $this->daoCaserne->update($caserne);
        $this->detail((string) $caserne->getNumCaserne());
    }

    /**
     * Display the confirmation page before deleting a caserne
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function delete(string $data): void
    {
        $caserne = $this->daoCaserne->find((int) $data);
        echo Renderer::render('caserneDelete', compact('caserne'));
    }

    /**
     * Delete the caserne and display the list
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function doDelete(string $data): void
    {
        $caserne = $this->daoCaserne->find((int) $data);
        $this->daoCaserne->delete($caserne);
        $this->show();
    }

    /**
     * Display the casernes located in the given city
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function showByVille(string $data): void
    {
        $casernes = $this->daoCaserne->findByVille($data);
        $total = count($casernes);
        echo Renderer::render('caserneListe', compact('casernes', 'total'));
    }
}
