<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Regex extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    public function __construct(protected string $pattern, ?string $message = null)
    {
        parent::__construct($message);
    }

    public function validate(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return preg_match($this->pattern, $value) === 1;
    }
}