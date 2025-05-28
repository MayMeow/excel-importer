<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

/**
 * Validates that a string matches a specified regular expression pattern.
 *
 * This validator uses preg_match to check if a string matches the provided
 * regular expression pattern. It returns false for non-string values.
 *
 * @attribute
 * @property string $pattern The regular expression pattern to match against
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Regex extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    /**
     * Constructor for the Regex validator.
     *
     * @param string $pattern The regular expression pattern to match against
     * @param string|null $message Custom error message to use when validation fails
     */
    public function __construct(protected string $pattern, ?string $message = null)
    {
        parent::__construct($message);
    }

    /**
     * Validates if the value matches the regular expression pattern.
     *
     * @param mixed $value The value to validate
     * @return bool True if value is a string and matches the pattern, false otherwise
     */
    public function validate(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return preg_match($this->pattern, $value) === 1;
    }
}
