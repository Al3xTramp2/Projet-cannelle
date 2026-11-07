<?php

namespace Supalta\Cannelle\utils\CSRF;

use Random\RandomException;

class CSRFCookie extends CSRF
{
    /**
     * @return string
     * @throws RandomException
     */
    #[\Override]
    public static function generateToken(): string
    {
        $data = [
            "token" => bin2hex(random_bytes(64)),
            "timestamp" => time(),
        ];
        setcookie(self::$token_key, json_encode($data), [
            "path" => "/",
            "httponly" => true,
            "samesite" => "Lax",
        ]);
        return $data["token"];
    }

    /**
     * @param string $token
     * @return bool
     */
    #[\Override]
    public static function check(string $token): bool
    {
        if (!isset($_COOKIE[self::$token_key])) {
            return false;
        }

        $stored = json_decode($_COOKIE[self::$token_key], true);
        setcookie(self::$token_key, "", ["expires" => time() - 3600, "path" => "/"]);

        if (!is_array($stored)) {
            return false;
        }
        if (!isset($stored["token"], $stored["timestamp"])) {
            return false;
        }
        if (!is_string($stored["token"]) || !is_int($stored["timestamp"])) {
            return false;
        }

        $age = time() - $stored["timestamp"];
        if ($age >= self::$token_lifetime) {
            return false;
        }

        if (!hash_equals($stored["token"], $token)) {
            return false;
        }

        return true;
    }
}
