<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a string's length meets or exceeds a specified minimum.
 *
 * This validator checks if a string's length is greater than or equal to the specified
 * minimum length. It returns false for non-string values.
 *
 * @attribute
 * @property int $minLength The minimum required length for the string
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class MinLength extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Constructor for the MinLength validator.
     *
     * @param int $minLength The minimum required length for the string
     * @param string|null $message Custom error message to use when validation fails
     */
    public function __construct(protected int $minLength, ?string $message = null)
    {
        parent::__construct($message);
    }

    /**
     * Validates if the string's length meets the minimum requirement.
     *
     * @param mixed $value The value to validate
     * @return bool True if value is a string and its length is >= minLength, false otherwise
     */
    public function validate(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return strlen($value) >= $this->minLength;
    }
}
