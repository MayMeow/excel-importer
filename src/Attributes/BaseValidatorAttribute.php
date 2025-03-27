<?php

namespace MayMeow\ExcelImporter\Attributes;

abstract class BaseValidatorAttribute
{
    public function __construct(protected ?string $message = null)
    {
        //
    }
}
