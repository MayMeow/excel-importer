<?php

namespace MayMeow\ExcelImporter\Tools;

interface FileLocatorInterface
{
    /**
     * @return string
     */
    public function locateExcelFile(): string;
}
