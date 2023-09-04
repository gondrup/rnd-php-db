<?php

namespace App\Patabase\DTO\Store;

class Field
{
    private string $fieldName;

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): Field
    {
        $this->fieldName = $fieldName;
        return $this;
    }
}