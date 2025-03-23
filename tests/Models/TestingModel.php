<?php
declare(strict_types=1);

namespace MayMeow\ExcelImporter\Test\Models;

use MayMeow\ExcelImporter\Attributes\Column;
use MayMeow\ExcelImporter\Attributes\Required;
use MayMeow\ExcelImporter\Models\BaseModel;

class TestingModel extends BaseModel
{
    #[Column('A')]
    #[Required]
    protected string $colA;

    #[Column('B')]
    protected string $colB;

    #[Column('C')]
    protected string $colC;

    #[Column('D')]
    protected string $colD;

    #[Column('E')]
    protected string $colE;

    #[Column('F')]
    protected string $colF;

    #[Column('G')]
    protected string $colG;

    #[Column('H')]
    protected string $colH;

    #[Column('I')]
    protected string $colI;

    #[Column('J')]
    protected string $colJ;

    #[Column('K')]
    protected string $colK;

    #[Column('L')]
    protected string $colL;

    /**
     * @return string
     */
    public function getColA(): string
    {
        return $this->colA;
    }

    /**
     * @return string
     */
    public function getColB(): string
    {
        return $this->colB;
    }

    /**
     * @return string
     */
    public function getColC(): string
    {
        return $this->colC;
    }

    /**
     * @return string
     */
    public function getColD(): string
    {
        return $this->colD;
    }

    /**
     * @return string
     */
    public function getColE(): string
    {
        return $this->colE;
    }

    /**
     * @return string
     */
    public function getColF(): string
    {
        return $this->colF;
    }

    /**
     * @return string
     */
    public function getColG(): string
    {
        return $this->colG;
    }

    /**
     * @return string
     */
    public function getColH(): string
    {
        return $this->colH;
    }

    /**
     * @return string
     */
    public function getColI(): string
    {
        return $this->colI;
    }

    /**
     * @return string
     */
    public function getColJ(): string
    {
        return $this->colJ;
    }

    /**
     * @return string
     */
    public function getColK(): string
    {
        return $this->colK;
    }

    /**
     * @return string
     */
    public function getColL(): string
    {
        return $this->colL;
    }

}