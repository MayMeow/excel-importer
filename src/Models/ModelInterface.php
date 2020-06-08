<?php

namespace MayMeow\ExcelImporter\Models;

interface ModelInterface
{
    public function writeValue($column, $value);
}