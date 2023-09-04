<?php

namespace App\Patabase\DTO\Criteria;

class Item
{
    private string $fieldName;
    private string $term;

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): Item
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    public function setTerm(string $term): Item
    {
        $this->term = $term;
        return $this;
    }
}