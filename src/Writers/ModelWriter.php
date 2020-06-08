<?php

namespace MayMeow\ExcelImporter\Writers;

use MayMeow\ExcelImporter\Models\ModelInterface;

class ModelWriter
{
    public function write(ModelInterface $model, $columnName, $value)
    {
        $model->writeValue($columnName, $value);
    }
}