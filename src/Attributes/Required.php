<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a field is present/set.
 *
 * This validator checks if a field is set (not null). The field can be empty,
 * but it must be present in the data being validated.
 *
 * @attribute
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Required extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Validates if the value is set (not null).
     *
     * @param mixed $value The value to validate
     * @return bool True if value is set (not null), false otherwise
     */
    public function validate(mixed $value): bool
    {
        // A field is required if it is set (can be empty though)
        return isset($value);
    }
}
