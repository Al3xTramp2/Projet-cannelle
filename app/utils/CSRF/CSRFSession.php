<?php

namespace Supalta\Cannelle\utils\CSRF;

use Override;

class CSRFSession extends CSRF
{

    /**
     * @return string
     */
    #[Override]
    public static function generateToken(): string
    {

    }

    /**
     * @param string $token
     * @return bool
     */
    #[Override]
    public static function check(string $token): bool
    {
        // TODO: Implement check() method.
    }
}