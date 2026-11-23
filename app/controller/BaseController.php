<?php

namespace Supalta\Cannelle\controller;

use Exception;
use Supalta\Cannelle\utils\Auth;
use Supalta\Cannelle\utils\Renderer;

/**
 * Base class of the controllers
 */
class BaseController
{
    /**
     * Constructor of the BaseController class
     */
    public function __construct()
    {
    }

    /**
     * Return true if the user can do the action on the table, else display the 403 page
     * @param string $table
     * @param string $perm
     * @return bool
     * @throws Exception
     */
    protected function allow(string $table, string $perm): bool
    {
        if (Auth::can($table, $perm)) {
            return true;
        }
        http_response_code(403);
        echo Renderer::render("error", ['message' => "Accès refusé"]);
        return false;
    }
}
