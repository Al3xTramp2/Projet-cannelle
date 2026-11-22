<?php

namespace Supalta\Cannelle\utils\validators\CSRF;

use Exception;

class CSRFRedis extends CSRF
{
    /**
     * @return string
     * @throws Exception
     */
    #[\Override]
    public static function generateToken(): string
    {
        throw new Exception("Not implemented yet");
    }

    /**
     * @param string $token
     * @return bool
     * @throws Exception
     */
    #[\Override]
    public static function check(string $token): bool
    {
        throw new Exception("Not implemented yet");
    }
}
