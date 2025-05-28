<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Each extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    public function __construct(protected ValidatorAttributeInterface $validator, ?string $message = null)
    {
        parent::__construct($message);
    }

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