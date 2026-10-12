<?php

//https://www.youtube.com/watch?v=tbYa0rJQyoM
//https://www.youtube.com/watch?v=-iW6lo6wq1Y
//https://openclassrooms.com/fr/courses/2078536-developpez-votre-site-web-avec-le-framework-symfony2-ancienne-version/2079345-le-routeur-de-symfony2

//echo "<pre>" . print_r($_SERVER, true) . "<pre>";
require_once '../vendor/autoload.php';

use Supalta\Cannelle\controller\CaserneController;
use Supalta\Cannelle\controller\PompierController;
use Supalta\Cannelle\controller\DefaultController;

if (isset($_SERVER["PATH_INFO"])) {
    $path = trim($_SERVER["PATH_INFO"], "/");
} else {
    $path = "";
}

$fragments = explode("/", $path);

//var_dump($fragment);

$control = array_shift($fragments);
//echo "control : $control <hr>";
switch ($control) {
    case '' :
    { //l'url est /
        defaultRoutes_get(["home"]);
        break;
    }
    case "pompier" :
    {
        //echo "Gestion des routes pour pompier <hr>";
        //calling function to prevend all hard code here
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            pompierRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            pompierRoutes_post($fragments);
        }
        break;
    }
    case "caserne" :
    {
        //echo "Gestion des routes pour caserne<hr>";
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            caserneRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            caserneRoutes_post($fragments);
        }
        break;
    }
    default :
    {
        defaultRoutes_get($fragments);
        break;
    }
}


function defaultRoutes_get($fragments): void
{
    $action = array_shift($fragments);

    switch ($action) {
        case "home" :
        {
            call_user_func_array([ new DefaultController(), "home"], $fragments);
            break;
        }
        case "error" :
        {
            call_user_func_array([ new DefaultController(), "error"], $fragments);
            break;
        }
        default :
        {
            echo "Action '$action' non defini <hr>";
            break;
        }
    }
}


function pompierRoutes_get($fragments)
{

    //var_dump($fragment);

    $action = array_shift($fragments);
    //var_dump($action);

    switch ($action) {
        case "liste" :
        {
            call_user_func_array([ new PompierController(), "show"], $fragments);
            break;
        }
        case "detail" :
        {
            call_user_func_array([ new PompierController(), "detail"], $fragments);
            break;
        }
        case 'ajouter' :
        {
            call_user_func_array([ new PompierController(), "create"], $fragments);
            break;
        }
        case "supprimer" :
        {
            call_user_func_array([new PompierController(), "delete"], $fragments);
            break;
        }
        case "modifier" :
        {
            call_user_func_array([new PompierController(), "update"], $fragments);
            break;
        }
        case "nom" :
        {
            call_user_func_array([new PompierController(), "showByName"], $fragments);
            break;
        }

        default :
        {
            echo "Action '$action' non defini <hr>";
            //Gestion du probleme
        }
    }
}

function pompierRoutes_post($fragments)
{

    $action = array_shift($fragments);
    switch ($action) {
        case "add":
            call_user_func_array([new PompierController(), "doCreate"], $fragments);
            break;
        case "delete":
            call_user_func_array([new PompierController(), "doDelete"], $fragments);
            break;
        case "update" :
            call_user_func_array([new PompierController(), "doUpdate"], $fragments);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function caserneRoutes_get($fragments)
{
    $action = array_shift($fragments);
    switch ($action) {
        case "liste":
            call_user_func_array([new CaserneController(), "show"], $fragments);
            break;
        case "detail" :
            call_user_func_array([new CaserneController(), "detail"], $fragments);
            break;
        case "ajouter" :
            call_user_func_array([new CaserneController(), "create"], $fragments);
            break;
        case "modifier" :
            call_user_func_array([new CaserneController(), "update"], $fragments);
            break;
        case "supprimer" :
            call_user_func_array([new CaserneController(), "delete"], $fragments);
            break;
        case "ville" :
            call_user_func_array([new CaserneController(), "showByVille"], $fragments);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function caserneRoutes_post($fragments)
{
    $action = array_shift($fragments);
    switch ($action) {
        case "add" :
            call_user_func_array([new CaserneController(), "doCreate"], $fragments);
            break;
        case "delete" :
            call_user_func_array([new CaserneController(), "doDelete"], $fragments);
            break;
        case "update" :
            call_user_func_array([new CaserneController(), "doUpdate"], $fragments);
            break;
        default:
            break;
    }
}
