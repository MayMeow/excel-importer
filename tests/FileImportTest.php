<?php

namespace MayMeow\ExcelImporter\Test;

use MayMeow\ExcelImporter\Test\Models\TestingModel;
use MayMeow\ExcelImporter\Test\Tools\TestingDataLocator;
use MayMeow\ExcelImporter\Writers\ModelWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\TestCase;

class FileImportTest extends TestCase
{
    /** @test */
    public function testImportingFile()
    {
        $xlsxReader = new Xlsx();
        $spreadsheet = $xlsxReader->load((new TestingDataLocator())->locateExcelFile());
        $writer = new ModelWriter();

        /** @var array<TestingModel> $modelArray */
        $modelArray = $writer->write(TestingModel::class, $spreadsheet);


        $this->assertEquals('a', $modelArray[0]->getColA());
        $this->assertEquals('g', $modelArray[0]->getColG());

        $this->assertEquals(6, $modelArray[1]->getColF());
    }
}