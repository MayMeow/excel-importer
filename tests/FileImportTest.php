<?php

namespace MayMeow\ExcelImporter\Test;

use MayMeow\ExcelImporter\Test\Models\TestingModel;
use MayMeow\ExcelImporter\Writers\ModelWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PHPUnit\Framework\TestCase;

class FileImportTest extends TestCase
{
    private static $testingFile = ROOT . DIRECTORY_SEPARATOR . 'testing-data.xlsx';

    /** @test */
    public function testImportingFile()
    {
        $xlsxReader = new Xlsx();
        $xlsxReader->getReadDataOnly();

        $spreadsheet = $xlsxReader->load(static::$testingFile);

        /** @var array<TestingModel> $modelArray */
        $modelArray = [];

        $writer = new ModelWriter();

        foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
            $model = new TestingModel();

            foreach ($row->getCellIterator() as $cell) {
                $writer->write($model, $cell->getColumn(), $cell->getValue());
            }

            array_push($modelArray, $model);
        }

        $this->assertEquals('a', $modelArray[0]->getColA());
        $this->assertEquals('g', $modelArray[0]->getColG());

        $this->assertEquals(6, $modelArray[1]->getColF());
    }
}