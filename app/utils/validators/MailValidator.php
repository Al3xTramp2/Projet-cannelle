<?php

namespace Supalta\Cannelle\utils\validators;

/**
 * Validates the syntax of an e-mail address
 */
class MailValidator implements InterfaceValidator
{
    /**
     * Check that the e-mail address has a valid syntax
     * @param string|int $code
     * @return bool
     */
    public function validate(string|int $code): bool
    {
        return filter_var($code, FILTER_VALIDATE_EMAIL) !== false;
    }
}
