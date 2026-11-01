<?php

namespace Supalta\Cannelle\utils;

use Supalta\Cannelle\utils\validators\InterfaceValidator;

/**
 * Keeps the values accepted by the validator of their key (a value without validator is kept)
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
     * Return the entries of the array whose value is accepted
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function visit(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (isset($this->validators[$key])) {
                $validator = $this->validators[$key];
                if ($validator->validate($value)) {
                    $result[$key] = $value;
                }
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
