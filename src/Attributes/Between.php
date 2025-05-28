<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a numeric value is between the specified minimum and maximum values (inclusive).
 * 
 * This validator checks if a numeric value (integer or float) falls within a specified range.
 * It returns false for non-numeric values.
 * 
 * @attribute
 * @property int|float $min The minimum allowed value (inclusive)
 * @property int|float $max The maximum allowed value (inclusive)
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Between extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Constructor for the Between validator.
     * 
     * @param int|float $min The minimum allowed value (inclusive)
     * @param int|float $max The maximum allowed value (inclusive)
     * @param string|null $message Custom error message to use when validation fails
     */
    public function __construct(
        protected int|float $min, 
        protected int|float $max, 
        ?string $message = null
    ) {
        parent::__construct($message);
    }

    /**
     * Validates if the value is between the specified minimum and maximum (inclusive).
     * 
     * @param mixed $value The value to validate
     * @return bool True if value is numeric and falls within the specified range, false otherwise
     */
    public function validate(mixed $value): bool
    {
        if (!is_int($value) && !is_float($value)) {
            return false;
        }

        return $value >= $this->min && $value <= $this->max;
    }
}