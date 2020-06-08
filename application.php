<?php

use MayMeow\ExcelImporter\Commands\ReadCommand;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$app = new Application('Excel to DB', '1.0');

$app->add(new ReadCommand());

$app->run();