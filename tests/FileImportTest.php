<?php

namespace MayMeow\ExcelImporter\Test;

use Exception;
use MayMeow\ExcelImporter\Attributes\Required;
use MayMeow\ExcelImporter\Test\Models\TestingModel;
use MayMeow\ExcelImporter\Test\Tools\TestingDataLocator;
use MayMeow\ExcelImporter\Validators\BaseValidator;
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

    /** @test */
    public function testImportingModelOnLineTwoShouldFail()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Property colA is required');

        $xlsxReader = new Xlsx();
        $spreadsheet = $xlsxReader->load((new TestingDataLocator())->locateExcelFile());
        $writer = new ModelWriter();

        /** @var array<TestingModel> $modelArray */
        $modelArray = $writer->write(TestingModel::class, $spreadsheet);

        $baseValidator = new BaseValidator();

        $baseValidator->validate($modelArray[2], against: Required::class);
    }

    /** @test */
    public function testImportingModelOnLineOneShouldPass()
    {
        $this->expectNotToPerformAssertions();

        $xlsxReader = new Xlsx();
        $spreadsheet = $xlsxReader->load((new TestingDataLocator())->locateExcelFile());
        $writer = new ModelWriter();

        /** @var array<TestingModel> $modelArray */
        $modelArray = $writer->write(TestingModel::class, $spreadsheet);

        $baseValidator = new BaseValidator();

        $baseValidator->validate($modelArray[1], against: Required::class);
    }
}