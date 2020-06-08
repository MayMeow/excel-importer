<?php

namespace MayMeow\ExcelImporter\Commands;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReadCommand extends Command
{
    protected static $defaultName = "app:read-file";

    protected function configure()
    {
        $this
            ->setDescription("Read data from XLSX file")

        ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'Path to XLSX file.', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getOption('file');

        $reder = new Xlsx();
        $reder->getReadDataOnly();

        $spreadsheet = $reder->load($fileName);
        $totalRows = $spreadsheet->getActiveSheet()->getHighestDataRow();

        $output->writeln("Total rows: $totalRows");

        // read all data
        foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row)
        {
            foreach ($row->getCellIterator() as $cell)
            {
                $output->writeln($cell->getColumn() . ' - ' . $cell->getValue());
            }
        }

        return Command::SUCCESS;
    }
}