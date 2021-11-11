<?php

namespace MayMeow\ExcelImporter\Attributes;

/**
 * Attribute Column
 * Specifying column in Excel from which you want to map data to model.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Column
{
    public function __construct(protected string $columnIdentifier)
    {
        $this->columnIdentifier = $this->columnIdentifier;
    }

    /**
     * @return string Column identifier
     */
    public function getColumnIdentifier(): string
    {
        return $this->columnIdentifier;
    }
}
