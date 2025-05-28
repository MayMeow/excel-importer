<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a numeric value is greater than or equal to a specified minimum.
 * 
 * This validator checks if a numeric value (integer or float) is greater than or equal
 * to the specified minimum value. It returns false for non-numeric values.
 * 
 * @attribute
 * @property int|float $min The minimum allowed value (inclusive)
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Min extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Constructor for the Min validator.
     * 
     * @param int|float $min The minimum allowed value (inclusive)
     * @param string|null $message Custom error message to use when validation fails
     */
    public function __construct(protected int|float $min, ?string $message = null)
    {
        parent::__construct($message);
    }

    /**
     * Validates if the value is greater than or equal to the minimum.
     * 
     * @param mixed $value The value to validate
     * @return bool True if value is numeric and >= minimum, false otherwise
     */
    public function validate(mixed $value): bool
    {
        if (!is_int($value) && !is_float($value)) {
            return false;
        }

        return $value >= $this->min;
    }
}