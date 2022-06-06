<?php

namespace MayMeow\ExcelImporter\Writers;

use MayMeow\ExcelImporter\Exceptions\MissingInterfaceException;
use MayMeow\ExcelImporter\Models\ModelInterface;
use MayMeow\ExcelImporter\Models\WriterRulesInterface;
use Meow\Hydrator\Hydrator;
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
     * @throws \Meow\Hydrator\Exception\NotInstantiableClassException
     */
    public function write(string $model, Spreadsheet $spreadsheet): array
    {
        $hydrator = new Hydrator();
        $reflector = new \ReflectionClass($model);
        $instacedModel = $reflector->newInstance();

        if (!$instacedModel instanceof WriterRulesInterface) {
            throw new MissingInputException('Model must implement ' . WriterRulesInterface::class);
        }

        $rules = $instacedModel->getRules();

        foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
            $modelData = [];

            /** @var Cell $cell */
            foreach ($row->getCellIterator() as $cell) {
                if (array_key_exists($cell->getColumn(), $rules)) {
                    $modelData[$rules[$cell->getColumn()]] = $cell->getValue();
                }
            }

            $emptyModel = $hydrator->hydrate($model, $modelData);

            array_push($this->models, $emptyModel);
        }

        return $this->models;
    }
}
