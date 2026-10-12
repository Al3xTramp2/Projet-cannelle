<?php

namespace Supalta\Cannelle\controller;

use Exception;
use Supalta\Cannelle\utils\Renderer;

/**
 * Controller of the default pages such as the home page
 */
class DefaultController extends BaseController
{
    /**
     * Display the home page
     * @return void
     * @throws Exception
     */
    public function home(): void
    {
        echo Renderer::render("home");
    }

    /**
     * Display the error page
     * @return void
     * @throws Exception
     */
    public function error(): void
    {
        echo Renderer::render("error");
    }
}
