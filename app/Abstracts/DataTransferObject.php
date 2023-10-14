<?php

namespace App\Abstracts;


use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject
{
    public function __construct(...$args)
    {
        if (is_array($args[0] ?? null)) {
            $args = $args[0];
        }

        $class            = new ReflectionClass($this);
        $publicProperties = $class->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($publicProperties as $property) {
            $property->setValue($this, Arr::get($args, $property->name, $property->getDefaultValue()));
            Arr::forget($args, $property->name);
        }
    }

    abstract public function toArray(): array;
}
