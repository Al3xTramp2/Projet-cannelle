<?php

namespace Supalta\Cannelle\utils\validators;

/**
 * Validates the strength of a password
 */
class PasswordValidator implements InterfaceValidator
{
    /**
     * Check that the password has over 12 characters, a lower case, an upper case, a digit and a symbol
     * @param string $password
     * @return bool
     */
    public function validate($password): bool
    {
        if (mb_strlen($password, "UTF-8") <= 12) {
            return false;
        }
        if (!preg_match('/\d/', $password)) {
            return false;
        }
        if (!preg_match('/[^\p{L}\p{N}\s]/u', $password)) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        return true;
    }
}
