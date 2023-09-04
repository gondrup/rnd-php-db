<?php

namespace App\Patabase\DTO\Criteria;

class Criteria
{
    public function __construct(
        private Items $items,
        private Sort $sort,
    )
    {}

    public function getItems(): Items
    {
        return $this->items;
    }

    public function getSort(): Sort
    {
        return $this->sort;
    }
}