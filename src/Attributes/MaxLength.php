<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a string's length does not exceed a specified maximum.
 *
 * This validator checks if a string's length is less than or equal to the specified
 * maximum length. It returns false for non-string values.
 *
 * @attribute
 * @property int $maxLength The maximum allowed length for the string
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class MaxLength extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Constructor for the MaxLength validator.
     *
     * @param int $maxLength The maximum allowed length for the string
     * @param string|null $message Custom error message to use when validation fails
     */
    public function __construct(protected int $maxLength, ?string $message = null)
    {
        parent::__construct($message);
    }

    /**
     * Validates if the string's length is within the maximum limit.
     *
     * @param mixed $value The value to validate
     * @return bool True if value is a string and its length is <= maxLength, false otherwise
     */
    public function validate(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return strlen($value) <= $this->maxLength;
    }
}
