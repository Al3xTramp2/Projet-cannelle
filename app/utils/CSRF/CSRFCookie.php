<?php

namespace Supalta\Cannelle\utils\CSRF;

class CSRFCookie extends CSRF
{

    /**
     * @return string
     */
    #[\Override]
    public static function generateToken(): string
    {
        // TODO: Implement generateToken() method.
    }

    /**
     * @param string $token
     * @return bool
     */
    #[\Override]
    public static function check(string $token): bool
    {
        // TODO: Implement check() method.
    }
}