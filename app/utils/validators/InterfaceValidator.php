<?php

namespace Supalta\Cannelle\utils\validators;

interface InterfaceValidator
{
    public function validate(string|int $code): bool;
}
