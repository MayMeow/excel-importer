<?php

namespace MayMeow\ExcelImporter\Models;

class BaseModel implements ModelInterface
{
    /**
     * Rules
     */
    protected static $rules = [];

    /**
     * Write value to model
     */
    public function writeValue($column, $value)
    {
        if (array_key_exists($column, static::$rules)) {
            $propertyName = static::$rules[$column];

            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }
    }
}