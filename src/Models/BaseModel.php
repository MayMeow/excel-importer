<?php

namespace MayMeow\ExcelImporter\Models;

use MayMeow\ExcelImporter\Attributes\Column;

class BaseModel implements ModelInterface
{
    /**
     * Rules
     */
    protected array $rules = [];

    public function __construct()
    {
        $this->buildRules();
    }

    /**
     * Write value to model
     */
    public function writeValue($column, $value)
    {
        if (array_key_exists($column, $this->rules)) {
            $propertyName = $this->rules[strtoupper($column)];

            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }
    }

    protected function buildRules(): void
    {
        $reflector = new \ReflectionClass($this);

        /** @var array<\ReflectionProperty> $properties */
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            /** @var array<\ReflectionAttribute> $attributes */
            $attributes = $property->getAttributes();

            if (!empty($attributes)) {
                /** @var Column $instatiated */
                $instatiated = $attributes[0]->newInstance();

                $this->rules[$instatiated->getColumnIdentifier()] = $property->getName();
            }
        }
    }
}