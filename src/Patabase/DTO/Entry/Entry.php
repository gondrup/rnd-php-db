<?php

namespace App\Patabase\DTO\Entry;

use App\Patabase\DTO\Collection;

class Entry extends Collection
{
    public static function fromArray(array $data): self
    {
        $entry = new self();
        foreach ($data as $k => $v) {
            $fieldValue = (new FieldValue())
                ->setFieldName($k)
                ->setValue($v);

            $entry[$k] = $fieldValue;
        }
        return $entry;
    }
}