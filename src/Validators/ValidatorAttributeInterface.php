<?php

namespace MayMeow\ExcelImporter\Validators;

interface ValidatorAttributeInterface
{
    public function validate(mixed $value): bool;
}
