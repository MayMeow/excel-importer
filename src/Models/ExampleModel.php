<?php

namespace MayMeow\ExcelImporter\Models;

use MayMeow\ExcelImporter\Test\Models\TestingModel;

/**
 * @deprecated will be removed in 1.2.0 release
 * @see TestingModel
 */
class ExampleModel extends BaseModel
{
    protected static $rules = [
        'A' => 'name',
        'B' => 'docummentNumber',
        'C' => 'count',
        'D' => 'quantityUnit',
        'E' => 'price',
        'F' => 'center'
    ];

    protected $name;
    protected $docummentNumber;
    protected $count;
    protected $quantityUnit;
    protected $price;
    protected $center;

    public function getName()
    {
        return $this->name;
    }

    public function getDocummentNumber()
    {
        return $this->docummentNumber;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getQuantityUnit()
    {
        return $this->quantityUnit;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getCenter()
    {
        return $this->center;
    }
}
