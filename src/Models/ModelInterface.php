<?php

namespace MayMeow\ExcelImporter\Models;

interface ModelInterface
{
    /**
     * @param string $column
     * @param string $value
     * @param array<string> $rules
     * @return void
     * @deprecated Using hydrator to write value instead
     * @see \Meow\Hydrator\Hydrator
     */
    public function writeValue(string $column, string $value, array $rules): void;
}
