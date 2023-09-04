<?php

namespace App\Patabase\DTO\Store;

use App\Patabase\DTO\Collection;

class StoreFields extends Collection
{
    /** @var Field[] */
    private array $container;

    public static function fromArray(array $data): self
    {
        $entry = new self();
        foreach ($data as $k => $v) {
            $entry[$v] = (new Field())->setFieldName($v);
        }
        return $entry;
    }
}