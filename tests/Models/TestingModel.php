<?php

namespace MayMeow\ExcelImporter\Test\Models;

use MayMeow\ExcelImporter\Models\BaseModel;

class TestingModel extends BaseModel
{
    protected static $rules = [
        'A' => 'colA',
        'B' => 'colB',
        'C' => 'colC',
        'D' => 'colD',
        'E' => 'colE',
        'F' => 'colF',
        'G' => 'colG',
        'H' => 'colH',
        'I' => 'colI',
        'J' => 'colJ',
        'K' => 'colK',
        'L' => 'colL',
    ];

    protected $colA;
    protected $colB;
    protected $colC;
    protected $colD;
    protected $colE;
    protected $colF;
    protected $colG;
    protected $colH;
    protected $colI;
    protected $colJ;
    protected $colK;
    protected $colL;

    /**
     * @return mixed
     */
    public function getColA()
    {
        return $this->colA;
    }

    /**
     * @return mixed
     */
    public function getColB()
    {
        return $this->colB;
    }

    /**
     * @return mixed
     */
    public function getColC()
    {
        return $this->colC;
    }

    /**
     * @return mixed
     */
    public function getColD()
    {
        return $this->colD;
    }

    /**
     * @return mixed
     */
    public function getColE()
    {
        return $this->colE;
    }

    /**
     * @return mixed
     */
    public function getColF()
    {
        return $this->colF;
    }

    /**
     * @return mixed
     */
    public function getColG()
    {
        return $this->colG;
    }

    /**
     * @return mixed
     */
    public function getColH()
    {
        return $this->colH;
    }

    /**
     * @return mixed
     */
    public function getColI()
    {
        return $this->colI;
    }

    /**
     * @return mixed
     */
    public function getColJ()
    {
        return $this->colJ;
    }

    /**
     * @return mixed
     */
    public function getColK()
    {
        return $this->colK;
    }

    /**
     * @return mixed
     */
    public function getColL()
    {
        return $this->colL;
    }

}