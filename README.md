# Excel importer

Simple and extendable library for loading data from Excel files (.xlsx) into objects.

This Library using `phpoffice/phpspreadsheet` to read from XLSX files. Look at their [Github](https://github.com/PHPOffice/PhpSpreadsheet)

## Read files - commandline with example data (Deprecated)

From command line with example data

```bash
php application.php app:read-file -f ./path/to/file.xlsx
```

## Via Source Code

Create new model which extending `MayMeow\ExcelImporter\Models\BaseModel`. To map column from excel to property use
`\MayMeow\ExcelImporter\Attributes\Column` attribute.

```php
<?php

use MayMeow\ExcelImporter\Models\BaseModel;

class ExampleModel extends BaseModel
{
    #[\MayMeow\ExcelImporter\Attributes\Column('A')]
    protected string $property;

    public function getProperty()
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

## Files

For getting path to files you can create Locator by implementing `MayMeow\ExcelImporter\Tools\FileLocatorInterface` which
is not required by XLS reader but recommended.

__License MIT__
