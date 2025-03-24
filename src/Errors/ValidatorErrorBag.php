<?php

namespace MayMeow\ExcelImporter\Errors;

use MayMeow\ExcelImporter\Exceptions\ValidationException;

class ValidatorErrorBag
{
    protected array $errors = [];

    public function addError(string $field, string $message)
    {
        $this->errors[$field][] = $message;
    }

    public function getErrors(?string $field = null): array
    {
        return $field ? ($this->errors[$field] ?? []) : $this->errors;
    }

    public function getFirstError(?string $field = null): ?string
    {
        if ($field) {
            return $this->errors[$field][0] ?? null;
        }

        foreach ($this->errors as $message) {
            return $message[0];
        }

        return null;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function throwIfNotEmpty()
    {
        if ($this->hasErrors()) {
            throw new ValidationException($this);
        }
    }
}