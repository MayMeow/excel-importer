<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a field is not empty.
 * 
 * This validator checks if a field is not null and not an empty string.
 * Unlike PHP's empty() function, this validator treats integer 0 and float 0.0 as valid values.
 * 
 * @attribute
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NotEmpty extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Validates if the value is not empty (not null and not empty string).
     * 
     * @param mixed $value The value to validate
     * @return bool True if value is not null and not empty string, false otherwise
     */
    public function validate(mixed $value): bool
    {
        return $value !== null && $value !== '';
    }
}
