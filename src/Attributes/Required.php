<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Required extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    public function validate(mixed $value): bool
    {
        // A field is required if it is set (can be empty though)
        return isset($value);
    }
}