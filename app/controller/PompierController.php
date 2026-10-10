<?php

namespace Supalta\Cannelle\controller;

use Supalta\Cannelle\model\DAOCaserne;
use Supalta\Cannelle\model\DAOPompier;
use Supalta\Cannelle\model\Pompier;
use Supalta\Cannelle\utils\Renderer;
use Supalta\Cannelle\utils\SingletonDataBaseMariaDB;
use DateTime;
use Exception;

class PompierController extends BaseController
{
    private DAOPompier $daoPompier;
    private DAOCaserne $daoCaserne;

    /**
     * Constructor of the PompierController class
     */
    public function __construct()
    {
        parent::__construct();
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $this->daoPompier = new DAOPompier($pdo);
        $this->daoCaserne = new DAOCaserne($pdo);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function show(): void
    {
        $pompiers = $this->daoPompier->findAll(0, 1000);
        $total = count($pompiers);
        $grades = Pompier::GRADES;
        echo Renderer::render("pompierListe", compact('pompiers', 'total', 'grades'));
    }

    /**
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function detail(string $data): void
    {
        $pompier = $this->daoPompier->find($data);
        echo Renderer::render("pompierDetail", compact('pompier'));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function create(): void
    {
        $casernes = $this->daoCaserne->findAll();
        $grades = Pompier::GRADES;
        echo Renderer::render("pompierCreate", compact('casernes', 'grades'));
    }

    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function doCreate(array $data): void
    {
        $pompier = (new Pompier())
            ->setPrenom($data['prenom'])
            ->setNom($data['nom'])
            ->setChefAgret($data['chefAgret'])
            ->setDateNaissance(new DateTime($data['dateNaissance']))
            ->setNumCaserne($data['numCaserne'])
            ->setCodeGrade($data['codeGrade'])
            ->setMatriculeRespo($data['matriculeRespo']);
        $this->daoPompier->save($pompier);
        $this->detail($pompier->getMatricule());
    }

    /**
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function update(string $data): void
    {
        $pompier = $this->daoPompier->find($data);
        $casernes = $this->daoCaserne->findAll();
        $grades = Pompier::GRADES;
        echo Renderer::render("pompierUpdate", compact('pompier', 'casernes', 'grades'));
    }

    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function doUpdate(array $data): void
    {
        $pompier = $this->daoPompier->find($data['matricule']);
        $pompier->setPrenom($data['prenom'])
            ->setNom($data['nom'])
            ->setChefAgret($data['chefAgret'])
            ->setDateNaissance(new DateTime($data['dateNaissance']))
            ->setNumCaserne($data['numCaserne'])
            ->setCodeGrade($data['codeGrade'])
            ->setMatriculeRespo($data['matriculeRespo']);
        $this->daoPompier->update($pompier);
        $this->detail($pompier->getMatricule());
    }

    /**
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function delete(string $data): void
    {
        $pompier = $this->daoPompier->find($data);
        echo Renderer::render("pompierDelete", compact('pompier'));
    }

    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function doDelete(array $data): void
    {
        $pompier = $this->daoPompier->find($data['matricule']);
        $this->daoPompier->delete($pompier);
        $this->show();
    }

    /**
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function showByName(string $data): void
    {
        $pompiers = $this->daoPompier->findByName($data);
        $total = count($pompiers);
        $grades = Pompier::GRADES;
        echo Renderer::render("pompierListe", compact('pompiers', 'total', 'grades'));
    }
}
