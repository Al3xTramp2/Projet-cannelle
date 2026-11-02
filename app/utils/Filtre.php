<?php

namespace Supalta\Cannelle\utils;

use Supalta\Cannelle\utils\validators\InterfaceValidator;

/**
 * Tells for each registered key whether its value is accepted by its validator
 */
class Filtre
{
    /** @var array<string, InterfaceValidator> */
    private array $validators = [];

    /**
     * Register the validator that tests the value of a key
     * @param string $key
     * @param InterfaceValidator $validator
     * @return void
     */
    public function accept(string $key, InterfaceValidator $validator): void
    {
        $this->validators[$key] = $validator;
    }

    /**
     * Return for each registered key whether its value is valid (false if the key is missing)
     * @param array<string, mixed> $data
     * @return array<string, bool>
     */
    public function visit(array $data): array
    {
        $result = [];
        foreach ($this->validators as $key => $validator) {
            if (isset($data[$key])) {
                $result[$key] = $validator->validate($data[$key]);
            } else {
                $result[$key] = false;
            }
        }
        return $result;
    }
}
