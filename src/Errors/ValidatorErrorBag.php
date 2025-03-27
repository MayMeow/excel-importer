<?php

namespace MayMeow\ExcelImporter\Errors;

use MayMeow\ExcelImporter\Exceptions\ValidationException;

class ValidatorErrorBag
{
    protected array $errors = [];

    public function addError(string $field, string $message, ?int $index = null, ?string $rule = null): void
    {
        $errorData = ['message' => $message];

        if ($rule !== null) {
            $errorData['rule'] = $rule;
        }

        if ($index !== null) {
            $this->errors[$index][$field][] = $errorData;
        } else {
            $this->errors[$field][] = $errorData;
        }
    }

    public function getErrors(?string $field = null): array
    {
        // indexed array
        if (!($field !== null && array_key_exists($field, $this->errors))
            && array_keys($this->errors) === range(
                min(array_keys($this->errors)),
                max(array_keys($this->errors))
            )) {
            $filteredErrors = $this->errors;
            foreach ($this->errors as $index => $fieldErrors) {
                foreach ($fieldErrors as $key => $_) {
                    if ($key !== $field) {
                        unset($filteredErrors[$index][$key]);
                    }
                }
            }

            return $filteredErrors;
        }

        return $field ? ($this->errors[$field] ?? []) : $this->errors;
    }

    public function getFirstError(
        ?string $field = null,
        ?int $index = null,
        bool $fullDetails = false
    ): string|array|null {
        // For provided Index and field
        if ($index !== null) {
            // Index is not exists return null
            if (!isset($this->errors[$index])) {
                return null;
            }

            // Index and field are provided
            if ($field !== null) {
                return $fullDetails
                ? (reset($this->errors[$index][$field]) ?? null)
                : ($this->errors[$index][$field][0]['message'] ?? null);
            }

            // filed is not provided, return first error from index from any field
            foreach ($this->errors[$index] ?? [] as $message) {
                return $fullDetails
                ? (reset($message) ?? null)
                : ($message[0]['message'] ?? null);
            }
        }

        // for provided field
        if ($field !== null) {
            // if field exists and is not list
            if (isset($this->errors[$field]) && !array_is_list($this->errors[$field])) {
                return $fullDetails
                ? (reset($this->errors[$field]) ?? null)
                : ($this->errors[$field][0]['message'] ?? null);
            }

            if (!isset($this->errors[$field])) {
                // field error not found, try to find in indexed array
                // This is case when you testing multiple models (array of models)
                // and trying to find error for specific field
                // try iterate ofver array and check if filed exists in member arrays
                foreach ($this->errors as $fieldErrors) {
                    if (isset($fieldErrors[$field])) {
                        return $fullDetails
                        ? (reset($fieldErrors[$field]) ?? null)
                        : ($fieldErrors[$field][0]['message'] ?? null);
                    }
                }

                return null; // filed error not found
            }
            // othervise GO TO general case
        }

        // general case: get first error from any field (entrie set)
        foreach ($this->errors as $_ => $fieldErrors) {
            foreach ($fieldErrors as $errorGroup) {
                if (array_is_list($errorGroup)) {
                    return $fullDetails
                    ? ($errorGroup[0] ?? null)
                    : ($errorGroup[0]['message'] ?? null);
                }

                return $fullDetails
                    ? ($errorGroup ?? null)
                    : ($errorGroup['message'] ?? null);
            }
        }

        return null;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function throwIfNotEmpty(): void
    {
        if ($this->hasErrors()) {
            throw new ValidationException($this);
        }
    }
}
