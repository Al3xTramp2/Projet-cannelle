<?php

namespace Supalta\Cannelle\utils\validators;

/**
 * Validates one value (strategy used by Filtre)
 */
interface InterfaceValidator
{
    /**
     * Return true if the value is valid
     * @param string|int $code
     * @return bool
     */
    public function validate(string|int $code): bool;
}
