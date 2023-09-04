<?php

namespace App\Patabase\DTO\Criteria;

class Sort
{
    private string $fieldName;
    private SortDirection $direction;

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): Sort
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    public function getDirection(): SortDirection
    {
        return $this->direction;
    }

    public function setDirection(SortDirection $direction): Sort
    {
        $this->direction = $direction;
        return $this;
    }
}