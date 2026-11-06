<?php

namespace Supalta\Cannelle\utils\CSRF;

abstract class CSRF
{
    protected static string $token_key = "csrf";

    /**
     * Generate and return the token. Store the token with the timestamp
     * @return string
     */
    public static abstract function generateToken(): string;

    /**
     * Check if the token is valid and the timestamp is not expired.
     * @param string $token
     * @return bool
     */
    public static abstract function check(string $token): bool;


}