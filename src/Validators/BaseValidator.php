<?php

namespace MayMeow\ExcelImporter\Validators;

use MayMeow\ExcelImporter\Models\ModelInterface;
use ReflectionClass;

class BaseValidator
{
    /**
     * Validate array of models
     * @param array<ModelInterface> $model
     * @param string $rule
     * @return void
     */
    public function validateMany(array $model, string $rule): void
    {
        foreach ($model as $m) {
            $this->validate($m, $rule);
        }
    }

    public function validate(ModelInterface $model, string $rule): void
    {
        $reflection = new ReflectionClass($model);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                if ($attribute->getName() == $rule) { // if there is attribute agains which we want to validate
                    $property->setAccessible(true);
                    $value = $property->getValue($model);

                    /** @var ValidatorAttributeInterface $a */
                    $a = $attribute->newInstance();

                    if (!$a->validate($value)) {
                        throw new \Exception('Property ' . $property->getName() . ' is required');
                    }
                }
            }
        }
    }
}
