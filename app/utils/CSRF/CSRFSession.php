<?php

namespace Supalta\Cannelle\utils\CSRF;

use Override;
use Random\RandomException;

class CSRFSession extends CSRF
{
    /**
     * @return string
     * @throws RandomException
     */
    #[Override]
    public static function generateToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $token = bin2hex(random_bytes(64));
        $_SESSION[self::$token_key] = ["token" => $token, "timestamp" => time()];
        return $token;
    }

    /**
     * @param string $token
     * @return bool
     */
    #[Override]
    public static function check(string $token): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (
            $_SESSION[self::$token_key]["token"] == $token
            && $_SESSION[self::$token_key]["timestamp"] > time() - self::$token_lifetime
        ) {
            unset($_SESSION[self::$token_key]);
            return true;
        } else {
            unset($_SESSION[self::$token_key]);
            return false;
        }
    }
}
