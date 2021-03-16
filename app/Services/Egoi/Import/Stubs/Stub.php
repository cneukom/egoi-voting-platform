<?php


namespace App\Services\Egoi\Import\Stubs;


use Exception;

abstract class Stub
{
    const FIELDS = [];

    protected array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function __get($key)
    {
        if (isset(static::FIELDS[$key])) {
            return $this->values[static::FIELDS[$key]];
        }
        throw new Exception('Undefined field ' . $key);
    }
}
