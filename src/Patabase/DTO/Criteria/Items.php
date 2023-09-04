<?php

namespace App\Patabase\DTO\Criteria;

use App\Patabase\DTO\Collection;

class Items extends Collection
{
    /** @var Item[] */
    private array $container;

    public static function fromArray(array $data): self
    {
        $entry = new self();
        foreach ($data as $k => $v) {
            $entry[] = (new Item())
                ->setFieldName($k)
                ->setTerm($v);
        }
        return $entry;
    }
}