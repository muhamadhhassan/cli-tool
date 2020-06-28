#!/usr/bin/php

<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use MiniTool\App;

$app = new App();

$app->runCommand($argv);
