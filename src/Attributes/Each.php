<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates each element in an array using a specified validator.
 * 
 * This validator applies another validator to every element in an array.
 * It returns false if the value is not an array or if any element fails validation.
 * 
 * @attribute
 * @property ValidatorAttributeInterface $validator The validator to apply to each array element
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Each extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Constructor for the Each validator.
     * 
     * @param ValidatorAttributeInterface $validator The validator to apply to each array element
     * @param string|null $message Custom error message to use when validation fails
     */
    public function __construct(protected ValidatorAttributeInterface $validator, ?string $message = null)
    {
        parent::__construct($message);
    }

    /**
     * Validates each element in the array using the specified validator.
     * 
     * @param mixed $value The value to validate (should be an array)
     * @return bool True if value is an array and all elements pass validation, false otherwise
     */
    public function validate(mixed $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $item) {
            if (!$this->validator->validate($item)) {
                return false;
            }
        }

        return true;
    }
}