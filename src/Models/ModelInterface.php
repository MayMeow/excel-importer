<?php

namespace MayMeow\ExcelImporter\Models;

interface ModelInterface
{
    /**
     * @param string $column
     * @param string $value
     * @param array<string> $rules
     * @return mixed
     */
    public function writeValue(string $column, string $value, array $rules): void;
}
