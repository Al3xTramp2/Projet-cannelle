<?php

namespace Supalta\Cannelle\controller;

use Exception;
use Supalta\Cannelle\utils\Auth;
use Supalta\Cannelle\utils\Renderer;
use Supalta\Cannelle\utils\validators\CSRF\CSRFCookie;

/**
 * Controller of the authentication: login and logout
 */
class AuthController extends BaseController
{
    /**
     * Display the login form
     * @return void
     * @throws Exception
     */
    public function login(): void
    {
        $csrfToken = CSRFCookie::generateToken();
        echo Renderer::render("auth", compact('csrfToken'));
    }

    /**
     * Log the user in from the form
     * @return void
     * @throws Exception
     */
    public function doLogin(): void
    {
        $csrfToken = $_POST['csrf_token'] ?? null;
        if (!is_string($csrfToken) || !CSRFCookie::check($csrfToken)) {
            http_response_code(403);
            return;
        }

        $user = Auth::login($_POST['login'] ?? '', $_POST['password'] ?? '');
        if ($user === null) {
            $erreur = true;
            $csrfToken = CSRFCookie::generateToken();
            echo Renderer::render("auth", compact('erreur', 'csrfToken'));
            return;
        }
        header("Location: /default/home");
    }

    /**
     * Log the user out
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
        header("Location: /auth/login");
    }
}
