<?php

namespace MayMeow\ExcelImporter\Errors;

use MayMeow\ExcelImporter\Exceptions\ValidationException;

class ValidatorErrorBag
{
    protected array $errors = [];

    public function addError(string $field, string $message, ?int $index = null)
    {
        if ($index !== null) {
            $this->errors[$index][$field][] = $message;
        } else {
            $this->errors[$field][] = $message;
        }
    }

    public function getErrors(?string $field = null): array
    {
        return $field ? ($this->errors[$field] ?? []) : $this->errors;
    }

    public function getFirstError(?string $field = null, ?int $index = null): ?string
    {

        // For provided Index and field
        if ($index !== null) {

            // Index is not exists return null
            if (!isset($this->errors[$index])) {
                return null;
            }

            // Index and field are provided
            if ($field !== null) {
                return $this->errors[$index][$field][0] ?? null;
            }

            // filed is not provided, return first error from index from any field
            foreach ($this->errors[$index] ?? [] as $message) {
                return $message[0] ?? null;
            }
        }

        // for provided field
        if ($field !== null) {
            // if field exists and is not list
            if (isset($this->errors[$field]) && !array_is_list($this->errors[$field])) {
                return $this->errors[$field][0] ?? null;
            }

            if (!isset($this->errors[$field])) {
                // field error not found, try to find in indexed array
                // This is case when you testing multiple models (array of models) and trying to find error for specific field
                // try iterate ofver array and check if filed exists in member arrays
                foreach ($this->errors as $fieldErrors) {
                    if (isset($fieldErrors[$field])) {
                        return $fieldErrors[$field][0] ?? null;
                    }
                }

                return null; // filed error not found
            }
            // othervise GO TO general case
        }

        // general case: get first error from any field (entrie set)
        foreach ($this->errors as $_ => $fieldErrors) {
            if (is_array($fieldErrors)) {
                foreach ($fieldErrors as $errorGroup) {
                    if (is_array($errorGroup)) {
                        return $errorGroup[0] ?? null;
                    } else {
                        return $errorGroup;
                    }
                }
            } else {
                return $fieldErrors;
            }
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