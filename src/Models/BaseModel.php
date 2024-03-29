<?php

namespace MayMeow\ExcelImporter\Models;

use MayMeow\ExcelImporter\Attributes\Column;

class BaseModel implements ModelInterface, WriterRulesInterface
{
    /**
     * Write value to model
     * @deprecated Use hydrator to write value instead of this
     * @see \Meow\Hydrator\Hydrator
     */
    public function writeValue(string $column, string $value, array $rules): void
    {
        if (array_key_exists($column, $rules)) {
            $propertyName = $rules[strtoupper($column)];

            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }
    }

    /**
     * @return array<string> Writer Rules
     */
    protected function buildRules(): array
    {
        $rules = [];

        $reflector = new \ReflectionClass($this);

        /** @var array<\ReflectionProperty> $properties */
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            /** @var array<\ReflectionAttribute<Column>> $attributes */
            $attributes = $property->getAttributes(Column::class);

            if (!empty($attributes)) {
                /** @var Column $instatiated */
                $instatiated = $attributes[0]->newInstance();

                $rules[$instatiated->getColumnIdentifier()] = $property->getName();
            }
        }

        return $rules;
    }

    public function getRules(): array
    {
        return $this->buildRules();
    }
}
