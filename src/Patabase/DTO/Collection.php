<?php

namespace App\Patabase\DTO;

abstract class Collection implements \ArrayAccess, \Iterator, \Countable
{
    private array $container = [];

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->container[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->container[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->container[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->container[$offset]);
    }

    public function current(): mixed
    {
        return current($this->container);
    }

    public function next(): void
    {
        next($this->container);
    }

    public function key(): mixed
    {
        return key($this->container);
    }

    public function valid(): bool
    {
        return $this->current() !== false;
    }

    public function rewind(): void
    {
        reset($this->container);
    }

    public function count(): int
    {
        return count($this->container);
    }
}