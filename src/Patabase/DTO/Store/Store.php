<?php

namespace App\Patabase\DTO\Store;

class Store
{
    public function __construct(
        private string $name,
        private StoreFields $fields,
    )
    {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getFields(): StoreFields
    {
        return $this->fields;
    }
}