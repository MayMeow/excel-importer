<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a string is a valid email address.
 *
 * This validator uses PHP's FILTER_VALIDATE_EMAIL filter to check if a string
 * represents a valid email address. It returns false for non-string values.
 *
 * @attribute
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Email extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Validates if the value is a valid email address.
     *
     * @param mixed $value The value to validate
     * @return bool True if value is a string and a valid email address, false otherwise
     */
    public function validate(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
