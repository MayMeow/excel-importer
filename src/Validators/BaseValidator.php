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
        $errors = $this->initialize();

        foreach ($model as $index => $m) {
            if (!is_object($m)) {
                $errors->addError('general', "Invalid model at index $index");
                continue;
            }

            $this->validate($m, $rule, $index);
        }

        // htrow exception if there are any errors
        if ($this->throwException) {
            $errors->throwIfNotEmpty();
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

    public function validate(ModelInterface $model, string $rule, ?int $index = null): ValidatorErrorBag
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
                        $errors->addError($property->getName(), 'Property ' . $property->getName() . ' is required', index: $index);

                        // fail on first error
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

        // throw exception if there are any errors unless you going over an array of models
        if ($this->throwException && is_null($index)) {
            $errors->throwIfNotEmpty();
        }

        return $errors;
    }
}
