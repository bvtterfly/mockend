<?php

namespace App\Support\Mockend\Fields;

class SequenceGenerator
{
    private array $services = [];

    public function init(string $serviceName, int $initialValue = 0)
    {
        if ($this->has($serviceName)) {
            return;
        }

        $this->services[$serviceName] = $initialValue;
    }

    public function has(string $serviceName): bool
    {
        return isset($this->services[$serviceName]);
    }

    public function getNext(string $serviceName): int
    {
        $this->init($serviceName);
        $this->services[$serviceName]++;

        return $this->services[$serviceName];
    }
}
