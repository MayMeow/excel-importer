<?php

namespace MayMeow\ExcelImporter\Exceptions;

use MayMeow\ExcelImporter\Errors\ValidatorErrorBag;

class ValidationException extends \Exception
{
    
    public function __construct(protected ValidatorErrorBag $errorBag)
    {
        parent::__construct('Validation failed');
    }

    public function getErrors(): ValidatorErrorBag
    {
        return $this->errorBag;
    }
}
