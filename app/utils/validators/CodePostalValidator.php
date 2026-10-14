<?php

namespace Supalta\Cannelle\utils\validators;

class CodePostalValidator implements InterfaceValidator
{

    public function validate($code): bool
    {
        if (mb_strlen($code) !== 5) {
            return false;
        }

        $dep   = (int) substr($code, 0, 2);
        $depOM = (int) substr($code, 0, 3);

        if ($dep >= 1 && $dep <= 95) {
            $last = (int) substr($code, 2, 3);
            return $last >= 0 && $last <= 999;
        }

        if ($depOM >= 971 && $depOM <= 988) {
            $last = (int) substr($code, 3, 2);
            return $last >= 0 && $last <= 99;
        }

        return false;
    }
}