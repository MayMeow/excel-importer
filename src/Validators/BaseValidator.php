<?php

namespace MayMeow\ExcelImporter\Validators;

use MayMeow\ExcelImporter\Errors\ValidatorErrorBag;
use MayMeow\ExcelImporter\Models\ModelInterface;
use ReflectionClass;

class BaseValidator
{
    protected ?ValidatorErrorBag $errors = null;

    public function __construct(protected bool $failFast = false, protected bool $throwException = false)
    {
        //
    }

    protected function initialize(): ValidatorErrorBag
    {
        if ($this->errors == null) {
            $this->errors = new ValidatorErrorBag();
        }

        return $this->errors;
    }

    /**
     * Validate array of models
     * @param array<ModelInterface> $model
     * @param string $rule
     */
    public function validateMany(array $model, ?string $rule = null): ValidatorErrorBag
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

        return $errors;
    }

    public function validate(ModelInterface $model, ?string $rule = null, ?int $index = null): ValidatorErrorBag
    {
        $reflection = new ReflectionClass($model);
        $properties = $reflection->getProperties();
        $errors = $this->initialize();

        foreach ($properties as $property) {
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                // if rule is defined skip all other rules
                if ($attribute->getName() !== $rule && $rule !== null) {
                    continue;
                }

                // skip also all attributes that not implements ValidatorAttributeInterface
                if (!is_subclass_of($attribute->getName(), ValidatorAttributeInterface::class)) {
                    continue;
                }

                // if there is attribute agains which we want to validate
                $property->setAccessible(true);
                $value = $property->getValue($model);
                $a = $attribute->newInstance();

                if (!$a->validate($value)) {
                    $errors->addError(
                        $property->getName(),
                        'Property ' . $property->getName() . ' is required',
                        index: $index
                    );

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

        // throw exception if there are any errors unless you going over an array of models
        if ($this->throwException && is_null($index)) {
            $errors->throwIfNotEmpty();
        }

        return $errors;
    }
}
