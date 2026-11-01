<?php

namespace Supalta\Cannelle\utils\validators;

class PasswordValidator implements InterfaceValidator
{
    public function validate($password): bool{
        if (mb_strlen($password, "UTF-8") <= 12) {
            return false;
        }

        if (!preg_match('/^(?=.*\p{Ll})(?=.*\p{Lu})(?=.*[0-9])(?=.*[^\p{L}0-9]).+$/u', $password)) {
            return false;
        }
        return true;
    }
}