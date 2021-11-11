<?php

namespace MayMeow\ExcelImporter\Models;

interface WriterRulesInterface
{
    /**
     * @return array<string> Writer rules
     */
    public function getRules(): array;
}