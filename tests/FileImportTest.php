<?php declare(strict_types=1);

namespace MayMeow\ExcelImporter\Test;

use Exception;
use MayMeow\ExcelImporter\Attributes\NotEmpty;
use MayMeow\ExcelImporter\Errors\ValidatorErrorBag;
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
    public function __construct(protected array $modelArray = [])
    {
        parent::__construct();

        $xlsxReader = new Xlsx();
        $spreadsheet = $xlsxReader->load((new TestingDataLocator())->locateExcelFile());
        $writer = new ModelWriter();

        /** @var array<TestingModel> $modelArray */
        $this->modelArray = $writer->write(TestingModel::class, $spreadsheet);
    }

    /** @test */
    public function testImportingFile()
    {
        $this->assertEquals('a', $this->modelArray[0]->getColA());
        $this->assertEquals('g', $this->modelArray[0]->getColG());

        $this->assertEquals(6, $this->modelArray[1]->getColF());
    }

    /** @test */
    public function testThrowingExceptionForMany()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed');

        $baseValidator = new BaseValidator(failFast: false, throwException: true);
        $baseValidator->validateMany($this->modelArray, rule: NotEmpty::class);
        $baseValidator->validate($this->modelArray[2], rule: NotEmpty::class);
    }

    /** @test */
    public function testThrowingException()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed');

        $baseValidator = new BaseValidator(failFast: false, throwException: true);
        $baseValidator->validate($this->modelArray[2], rule: NotEmpty::class);
    }

    /** @test */
    public function testImportingModelOnLineTwoShouldFail()
    {
        $baseValidator = new BaseValidator(failFast: false, throwException: true);

        try {
            $baseValidator->validateMany($this->modelArray, rule: NotEmpty::class);
        } catch (ValidationException $e) {
            $this->assertEquals('Property colA is required', $e->getErrors()->getFirstError());
        }
    }

    /** @test */
    public function testImportingModelOnLineOneShouldPass()
    {
        $this->expectNotToPerformAssertions();

        $baseValidator = new BaseValidator(failFast: true, throwException: true);

        $baseValidator->validate($this->modelArray[1], rule: NotEmpty::class);
    }

    /** @test */
    public function testValidatorForMany()
    {
        $baseValidator = new BaseValidator(failFast: true, throwException: false);

        /** @var ValidatorErrorBag $e */
        $e = $baseValidator->validateMany($this->modelArray, rule: NotEmpty::class);

        if ($e->hasErrors()) {
            $this->assertEquals('Property colA is required', $e->getFirstError()); // return any first error
            $this->assertEquals('Property colA is required', $e->getFirstError(index: 2)); // return any first error on index 2
            $this->assertEquals('Property colA is required', $e->getFirstError(field: 'colA')); // return first error for field colA in any index
            $this->assertEquals('Property colA is required', $e->getFirstError(field: 'colA', index: 2)); // return first error for field colA on index 2
            $this->assertEquals(null, $e->getFirstError(index: 1)); // row 1 should be valid
        }
    }

    /** @test */
    public function testValidation()
    {
        $baseValidator = new BaseValidator(failFast: true, throwException: false);

        $e = $baseValidator->validate($this->modelArray[2], rule: NotEmpty::class);

        if ($e->hasErrors()) {
            $this->assertEquals('Property colA is required', $e->getFirstError()); // first error for any field
            $this->assertEquals('Property colA is required', $e->getFirstError(field: 'colA')); // first error for field colA
            $this->assertEquals(null, $e->getFirstError(field: 'colB')); // field colB -> there should be no error
        }
    }

    /** @test */
    public function testValidationForAllRules()
    {
        $baseValidator = new BaseValidator(failFast: true, throwException: false);

        // do not define rule here
        $e = $baseValidator->validate($this->modelArray[2]);

        if ($e->hasErrors()) {
            $this->assertEquals('Property colA is required', $e->getFirstError()); // first error for any field
            $this->assertEquals('Property colA is required', $e->getFirstError(field: 'colA')); // first error for field colA
            $this->assertEquals(null, $e->getFirstError(field: 'colB')); // field colB -> there should be no error
        }
    }

    /** @test */
    public function testValidatorForManyForAllRules()
    {
        $baseValidator = new BaseValidator(failFast: true, throwException: false);

        /** @var ValidatorErrorBag $e */
        $e = $baseValidator->validateMany($this->modelArray, rule: NotEmpty::class);

        if ($e->hasErrors()) {
            $this->assertEquals('Property colA is required', $e->getFirstError()); // return any first error
            $this->assertEquals('Property colA is required', $e->getFirstError(index: 2)); // return any first error on index 2
            $this->assertEquals('Property colA is required', $e->getFirstError(field: 'colA')); // return first error for field colA in any index
            $this->assertEquals('Property colA is required', $e->getFirstError(field: 'colA', index: 2)); // return first error for field colA on index 2
            $this->assertEquals(null, $e->getFirstError(index: 1)); // row 1 should be valid
        }
    }


}