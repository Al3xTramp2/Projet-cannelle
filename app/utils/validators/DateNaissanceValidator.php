<?php

namespace Supalta\Cannelle\utils\validators;

use DateTime;

class DateNaissanceValidator implements InterfaceValidator
{
    /**
     * Check that the date exists and that the person is aged 18 to 60
     * @param string|int $code
     * @return bool
     */
    public function validate(string|int $code): bool
    {
        if (!is_string($code)) {
            return false;
        }

        $date = DateTime::createFromFormat("Y-m-d", $code);
        if ($date === false) {
            return false;
        }

        if ($date->format('Y-m-d') !== $code) {
            return false;
        }

        $nowDate = new DateTime();
        if ($date > $nowDate) {
            return false;
        }

        $age = $date->diff($nowDate)->y;

        return $age >= 18 && $age <= 60;
    }
}
