<?php

namespace Supalta\Cannelle\utils\CSRF;

abstract class CSRF
{
    protected static string $token_key = "csrf";
    protected static int $token_lifetime = 600; // 10 min

    /**
     * Generate and return the token. Store the token with the timestamp
     * @return string
     */
    abstract public static function generateToken(): string;

    /**
     * Check if the token is valid and the timestamp is not expired.
     * @param string $token
     * @return bool
     */
    abstract public static function check(string $token): bool;
}
