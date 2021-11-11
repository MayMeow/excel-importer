# Excel importer

Library to transform XLSX files into models. 

This Library using `phpoffice/phpspreadsheet` to read from XLSX files. Look at their [Github](https://github.com/PHPOffice/PhpSpreadsheet)

## Read files - commandline with example data

From command line with example data

```bash
php application.php app:read-file -f ./path/to/file.xlsx
```

## Via Source Code

Create new model which extending `MayMeow\ExcelImporter\Models\BaseModel`.

```php
<?php

use MayMeow\ExcelImporter\Models\BaseModel;

class ExampleModel extends BaseModel
{
    /**
     *  Bindings between columns and model properties
     */
    protected static $rules = [
        'A' => 'property',
    ];

    protected $property;

    public function getPropery()
    {
        return $this->property;
    }
}
```

read from file following example is reading from active sheet

```php
// ...

use MayMeow\ExcelImporter\Models\ExampleModel;
use MayMeow\ExcelImporter\Writers\ModelWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

// ...
public function testImportingFile()
{
    $xlsxReader = new Xlsx();
    $spreadsheet = $xlsxReader->load((new TestingDataLocator())->locateExcelFile());
    $writer = new ModelWriter();
    
    /** @var array<TestingModel> $modelArray */
    $modelArray = $writer->write(TestingModel::class, $spreadsheet);
}
// ...
```
