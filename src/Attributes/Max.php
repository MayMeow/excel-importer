<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a numeric value is less than or equal to a specified maximum.
 *
 * This validator checks if a numeric value (integer or float) is less than or equal
 * to the specified maximum value. It returns false for non-numeric values.
 *
 * @attribute
 * @property int|float $max The maximum allowed value (inclusive)
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Max extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Constructor for the Max validator.
     *
     * @param int|float $max The maximum allowed value (inclusive)
     * @param string|null $message Custom error message to use when validation fails
     */
    public function __construct(protected int|float $max, ?string $message = null)
    {
        parent::__construct($message);
    }

    /**
     * Validates if the value is less than or equal to the maximum.
     *
     * @param mixed $value The value to validate
     * @return bool True if value is numeric and <= maximum, false otherwise
     */
    public function validate(mixed $value): bool
    {
        if (!is_int($value) && !is_float($value)) {
            return false;
        }

        return $value <= $this->max;
    }
}
