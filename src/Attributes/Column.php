<?php

namespace MayMeow\ExcelImporter\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Column
{
    public function __construct(protected string $columnIdentifier)
    {
        $this->columnIdentifier = $this->columnIdentifier;
    }

    /**
     * @return string
     */
    public function getColumnIdentifier(): string
    {
        return $this->columnIdentifier;
    }
}
