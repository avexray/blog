<?php

namespace App;

class ServiceContainer
{
    private array $factories = [];
    private array $instances = [];

    public function singleton(string $id, callable $factory): void
    {
        $this->factories[$id] = $factory;
    }

    public function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->factories[$id])) {
            throw new \RuntimeException("Service not found: {$id}");
        }

        return $this->instances[$id] = ($this->factories[$id])($this);
    }
}