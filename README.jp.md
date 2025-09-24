# Excel importer

[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/D1D5DMOTA)

Excel ファイル（.xlsx）からオブジェクトへデータを読み込むための、シンプルで拡張可能なライブラリです。

このライブラリは XLSX の読み込みに `phpoffice/phpspreadsheet` を使用しています。詳細は彼らの [Github](https://github.com/PHPOffice/PhpSpreadsheet) をご覧ください。

## Read files - commandline with example data (Deprecated)

コマンドラインから（サンプルデータを使用）

```bash
php application.php app:read-file -f ./path/to/file.xlsx
```

## Via Source Code

`MayMeow\ExcelImporter\Models\BaseModel` を継承した新しいモデルを作成します。Excel の列をプロパティにマッピングするには、`\MayMeow\ExcelImporter\Attributes\Column` 属性を使用します。

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

ファイルから読み取ります。以下の例ではアクティブシートを対象とします。

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

## Validators :tada: (from v1.2.0)

保存先へ格納する前に入力データを検証できるオプションを追加しました。`namespace MayMeow\ExcelImporter\Validators;` の新しいクラスを使用します。バリデータは属性（ルール）によって、フィールド（プロパティ）のデータが有効かどうかを検証します。

### Available Validation Attributes

#### Basic Constraints
```php
#[Required]   // Field must be present (but can be empty)
#[NotEmpty]   // Field must be present and not empty
```

#### String Constraints
```php
#[MaxLength(50)]  // Limits string length to 50 characters
#[MinLength(5)]   // Ensures at least 5 characters
```

#### Numerical Constraints
```php
#[Min(1)]     // Minimum allowed value
#[Max(100)]   // Maximum allowed value
#[Between(1, 10)] // Ensures value is between 1 and 10
```

#### Format Constraints
```php
#[Email]      // Validates email format
#[Url]        // Validates URL format
#[Regex("/^[a-zA-Z0-9]+$/")]  // Custom regex validation
```

#### Collection Constraints
```php
#[Each(new Min(1))]  // Applies Min(1) to each array element
#[Each(new Email)]   // Ensures every item in an array is an email
```

#### Example

```php
class TestingModel extends BaseModel
{
    #[Column('A')]
    #[NotEmpty]
    #[MaxLength(50)]
    protected string $name;
    
    #[Column('B')]
    #[Email]
    protected string $email;
    
    #[Column('C')]
    #[Min(18)]
    #[Max(100)]
    protected int $age;

// ...
}
```

次のようにバリデータでデータを検証できます。

```php
$baseValidator = new BaseValidator(failFast: true, throwException: false);
// fast fail with fail on first error if set tot true otherwise will continue until end and return ValidatorBag
// throwExcpetion will throw ValidationException if set to true

// you can validate arrory of models
$e = $baseValidator->validateMany($this->modelArray, rule: NotEmpty::class);

// or just single model
$baseValidator->validate($this->modelArray[2], rule: NotEmpty::class);

//then you can get error messages as follows
if ($e->hasErrors()) {
    // return any first error for any field or any row (for both validate and validateMany)
    $e->getFirstError(); 

    // return any first error on index 2 (use this for indexed - for validateMany)
    $e->getFirstError(index: 2); 

    // return first error for field colA in any index (for both validate and validateMany)
    $e->getFirstError(field: 'colA'); 

    // return first error for field colA on index 2 (for validateMany)
    $e->getFirstError(field: 'colA', index: 2); 
}
```

### Error bag

検証は次のように動作します。エラーは `ValidatorErrorBag` に保存されます。独自のバリデータを実装しつつ、このエラーバッグを利用したい場合は、以下のように使用できます。

```php
$errors = new ValidatorErrorBag();

// Errors for multiple models (indexed)
$errors->addError('name', 'Name is required', 0);
$errors->addError('email', 'Invalid email format', 1);
$errors->addError('password', 'Password too short', 2);

// Non-indexed errors (single model)
$errors->addError('age', 'Age must be a number');

// 🔥 Get first error globally
echo $errors->getFirstError(); // Output: "Name is required"

// 🔥 Get first error for a specific model (index 1)
echo $errors->getFirstError(null, 1); // Output: "Invalid email format"

// 🔥 Get first error for a specific field (globally)
echo $errors->getFirstError('password'); // Output: "Password too short"

// 🔥 Get first error for a specific field across all indexed models
echo $errors->getFirstError('email'); // Output: "Invalid email format"

// 🔥 Get first error from any row for a **numeric field key**
echo $errors->getFirstError(0); // Output: "Name is required" (first error from index 0)
```

### Custom rules (attributes)

新しいルールを作成したい場合は、新しい属性を作成してください。その属性は `MayMeow\ExcelImporter\Validators\ValidatorAttributeInterface;` を実装する必要があります。

バリデータは、プロパティに付与された属性のみを検出します。

## Files

ファイルへのパスを取得するために、`MayMeow\ExcelImporter\Tools\FileLocatorInterface` を実装した Locator を作成できます。XLS リーダーでは必須ではありませんが、推奨されています。

__ライセンス AGPL v3.0__