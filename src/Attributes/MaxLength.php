<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class MaxLength extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    public function __construct(protected int $maxLength, ?string $message = null)
    {
        parent::__construct($message);
    }

    public function validate(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return strlen($value) <= $this->maxLength;
    }
}