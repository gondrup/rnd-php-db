<?php

namespace App\Patabase;

use App\Patabase\DTO\Criteria\Criteria;
use App\Patabase\DTO\Criteria\Item;
use App\Patabase\DTO\Criteria\Items;
use App\Patabase\DTO\Criteria\Sort;
use App\Patabase\DTO\Criteria\SortDirection;
use App\Patabase\DTO\Entry\Entry;
use App\Patabase\DTO\Store\Store;
use App\Patabase\DTO\Store\StoreFields;
use App\Patabase\Exception\PatabaseException;

class Patabase
{
    const PATH_DEF = '/fields.def';
    const PATH_DATA = '/data';

    public function __construct(
        private string $dataDir,
    )
    {}

    private function getStorePath(string $storeName): string
    {
        return $this->dataDir.'/'.$storeName;
    }

    public function storeExists(string $storeName): bool
    {
        return (is_dir($this->getStorePath($storeName)));
    }

    public function createStore(string $storeName, array $fields)
    {
        if ($this->storeExists($storeName)) {
            throw new PatabaseException('Cannot create store with name "'.$storeName.'" as one already exists.');
        }

        $storeFields = StoreFields::fromArray($fields);
        $store = new Store($storeName, $storeFields);

        mkdir(directory: $this->getStorePath($storeName), recursive: true);
        mkdir(directory: $this->getStorePath($storeName).self::PATH_DATA, recursive: true);

        $def = implode(',', array_map(
            fn ($f) => $f->getFieldName(),
            iterator_to_array($store->getFields())
        ));

        file_put_contents($this->getStorePath($store->getName()).self::PATH_DEF, $def);
    }

    private function loadStore(string $storeName): Store
    {
        if (!$this->storeExists($storeName)) {
            throw new PatabaseException('Cannot load store "'.$storeName.'"');
        }

        $def = file_get_contents($this->getStorePath($storeName).self::PATH_DEF);
        $fields = explode(',', $def);

        $storeFields = StoreFields::fromArray($fields);
        $store = new Store($storeName, $storeFields);

        return $store;
    }

    private function validateEntry(Store $store, Entry $entry): void
    {
        foreach ($entry as $fieldValue) {
            if (!isset($store->getFields()[$fieldValue->getFieldName()])) {
                throw new PatabaseException('Entry not valid for "'.$store->getName().'" store, no such field with name: "'.$fieldValue->getFieldName().'"');
            }
        }
    }
    
    public function add(string $storeName, array $data)
    {
        $store = $this->loadStore($storeName);
        $entry = Entry::fromArray($data);

        $this->validateEntry($store, $entry);

        // TODO: search for identical record first

        $data = implode(',', array_map(
            fn ($f) => $f->getFieldName().'='.$f->getValue(),
            iterator_to_array($entry)
        ));

        $fileName = hash('sha1', $data);
        $fullPath = $this->getStorePath($store->getName()).self::PATH_DATA.'/'.$fileName;
        if (file_exists($fullPath)) {
            throw new PatabaseException('Cannot add duplicate entry to "'.$store->getName().'" store');
        }

        file_put_contents($fullPath, $data);
    }

    public function select(string $storeName, array $criteriaItemValues, array $sortValues): array
    {
        $store = $this->loadStore($storeName);

        $criteriaItems = Items::fromArray($criteriaItemValues);
        $sort = new Sort();
        $sort->setFieldName($sortValues[0]);
        $sort->setDirection(match($sortValues[1]) {
            'asc' => SortDirection::Asc,
            'desc' => SortDirection::Desc,
        });

        $criteria = new Criteria($criteriaItems, $sort);
        $recordFiles = array_diff(scandir($this->getStorePath($store->getName()).self::PATH_DATA),['.', '..']);

        $results = [];
        foreach ($recordFiles as $file) {
            $content = file_get_contents($this->getStorePath($storeName).self::PATH_DATA.'/'.$file);
            $entryValues = [];
            foreach(explode(',', $content) as $v) {
                $split = explode('=', $v);
                $entryValues[$split[0]] = $split[1];
            }
            /** @var Entry $entry */
            $entry = Entry::fromArray($entryValues);

            foreach ($criteria->getItems() as $criterion) {
                /** @var Item $criterion */
                if ($entry[$criterion->getFieldName()]->getValue() !== $criterion->getTerm()) {
                    continue(2);
                }

                $results[] = $entry;
            }
        }

        if (!empty($results)) {
            usort($results, function($a, $b) use ($sort) {
                if ($sort->getDirection() === SortDirection::Asc) {
                    return ($a[$sort->getFieldName()] <=> $b[$sort->getFieldName()]);
                } else {
                    return ($b[$sort->getFieldName()] <=> $a[$sort->getFieldName()]);
                }
            });
        }

        return $results;
    }

    public function delete(string $storeName, array $criteria)
    {
        // TODO: implement deletion of entries
    }
}