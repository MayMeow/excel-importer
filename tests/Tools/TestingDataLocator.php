<?php

namespace MayMeow\ExcelImporter\Test\Tools;

use MayMeow\ExcelImporter\Tools\FileLocatorInterface;

class TestingDataLocator implements FileLocatorInterface
{

    public function locateExcelFile(): string
    {
        return ROOT . DIRECTORY_SEPARATOR . 'testing-data.xlsx';
    }
}