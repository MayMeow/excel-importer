<?php

namespace MayMeow\ExcelImporter\Attributes;

use MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Between extends BaseValidatorAttribute implements ValidatorAttributeInterface
{
    public function __construct(
        protected int|float $min, 
        protected int|float $max, 
        ?string $message = null
    ) {
        parent::__construct($message);
    }

    public function validate(mixed $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return $value >= $this->min && $value <= $this->max;
    }
}