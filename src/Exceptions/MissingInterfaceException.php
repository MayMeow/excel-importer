<?php

namespace MayMeow\ExcelImporter\Exceptions;

use Throwable;

class MissingInterfaceException extends \Exception
{
    public function __construct(string $message = "", int $code = 10, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
