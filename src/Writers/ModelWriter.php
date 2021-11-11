<?php

namespace MayMeow\ExcelImporter\Writers;

use MayMeow\ExcelImporter\Exceptions\MissingInterfaceException;
use MayMeow\ExcelImporter\Models\ModelInterface;
use MayMeow\ExcelImporter\Models\WriterRulesInterface;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\Console\Exception\MissingInputException;

class ModelWriter
{
    /** @var array<ModelInterface> $models */
    protected array $models = [];

    /**
     * @param class-string $model
     * @param Spreadsheet $spreadsheet
     * @return array<ModelInterface>
     * @throws \ReflectionException|MissingInterfaceException
     */
    public function write(string $model, Spreadsheet $spreadsheet): array
    {
        $reflector = new \ReflectionClass($model);
        $instacedModel = $reflector->newInstance();

        if (!$instacedModel instanceof ModelInterface) {
            throw new MissingInterfaceException('Model must implement ' . ModelInterface::class);
        }

        if (!$instacedModel instanceof WriterRulesInterface) {
            throw new MissingInputException('Model must implement ' . WriterRulesInterface::class);
        }

        $rules = $instacedModel->getRules();

        foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
            /** @var ModelInterface $emptyModel */
            $emptyModel = new $model();

            /** @var Cell $cell */
            foreach ($row->getCellIterator() as $cell) {
                $emptyModel->writeValue($cell->getColumn(), $cell->getValue(), $rules);
            }

            array_push($this->models, $emptyModel);
        }

        return $this->models;
    }
}
