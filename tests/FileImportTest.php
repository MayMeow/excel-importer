<?php

namespace MayMeow\ExcelImporter\Test;

use Exception;
use MayMeow\ExcelImporter\Attributes\NotEmpty;
use MayMeow\ExcelImporter\Exceptions\ValidationException;
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
        #$this->expectException(ValidationException::class);
        #$this->expectExceptionMessage('Validation failed');

        $xlsxReader = new Xlsx();
        $spreadsheet = $xlsxReader->load((new TestingDataLocator())->locateExcelFile());
        $writer = new ModelWriter();

        /** @var array<TestingModel> $modelArray */
        $modelArray = $writer->write(TestingModel::class, $spreadsheet);

        $baseValidator = new BaseValidator(failFast: true, throwException: true);

        #$baseValidator->validateMany($modelArray, rule: NotEmpty::class);

        try {
            $baseValidator->validateMany($modelArray, rule: NotEmpty::class);
        } catch (ValidationException $e) {
            $this->assertEquals('Property colA is required', $e->getErrors()->getFirstError());
        }
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

        $baseValidator = new BaseValidator(failFast: true, throwException: true);

        $baseValidator->validate($modelArray[1], rule: NotEmpty::class);
    }
}