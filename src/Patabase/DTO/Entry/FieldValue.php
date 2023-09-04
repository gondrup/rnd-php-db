<?php

namespace App\Patabase\DTO\Entry;

class FieldValue
{
    private string $fieldName;
    private null|string|int|float|bool $value;

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): FieldValue
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    public function getValue(): float|bool|int|string|null
    {
        return $this->value;
    }

    public function setValue(float|bool|int|string|null $value): FieldValue
    {
        $this->value = $value;
        return $this;
    }
}