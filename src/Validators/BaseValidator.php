<?php

namespace MayMeow\ExcelImporter\Validators;

use MayMeow\ExcelImporter\Errors\ValidatorErrorBag;
use MayMeow\ExcelImporter\Models\ModelInterface;
use PHPUnit\Util\Xml\Validator;
use ReflectionClass;

class BaseValidator
{
    protected ?ValidatorErrorBag $errors = null;

    public function __construct(protected bool $failFast = false, protected bool $throwException = false)
    {
        //
    }

    /**
     * Validate array of models
     * @param array<ModelInterface> $model
     * @param string $rule
     * @return void
     */
    public function validateMany(array $model, string $rule): ValidatorErrorBag
    {
        foreach ($model as $index => $m) {
            $this->validate($m, $rule);
        }

        return $this->errors;
    }

    protected function initialize(): ValidatorErrorBag
    {
        if ($this->errors == null) {
            $this->errors = new ValidatorErrorBag();
        }

        return $this->errors;
    }

    public function validate(ModelInterface $model, string $rule): ValidatorErrorBag
    {
        $reflection = new ReflectionClass($model);
        $properties = $reflection->getProperties();
        $errors = $this->initialize();

        foreach ($properties as $property) {
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                if ($attribute->getName() == $rule) { // if there is attribute agains which we want to validate
                    $property->setAccessible(true);
                    $value = $property->getValue($model);

                    /** @var ValidatorAttributeInterface $a */
                    $a = $attribute->newInstance();

                    if (!$a->validate($value)) {
                        $errors->addError($property->getName(), 'Property ' . $property->getName() . ' is required');

                        if ($this->failFast) {
                            if ($this->throwException) {
                                $errors->throwIfNotEmpty();
                            }

                            return $errors;
                        }
                    }

                }
            }
        }

        if ($this->throwException) {
            $errors->throwIfNotEmpty();
        }

        return $errors;
    }
}
