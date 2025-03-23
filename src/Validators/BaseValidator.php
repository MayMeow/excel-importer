<?php

namespace MayMeow\ExcelImporter\Validators;

use MayMeow\ExcelImporter\Models\ModelInterface;
use ReflectionClass;

class BaseValidator
{
    public function validate(ModelInterface $model, string $against): void
    {
        $reflection = new ReflectionClass($model);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                if ($attribute->getName() == $against) { // if there is attribute agains which we want to validate
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
