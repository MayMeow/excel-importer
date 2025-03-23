<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NotEmpty extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    public function validate(mixed $value): bool
    {
        if (empty($value) || $value == '') {
            return false;
        }

        return true;
    }
}
