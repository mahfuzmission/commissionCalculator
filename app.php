<?php

use CommissionTask\Script\Script;
use CommissionTask\Script\ReflectionResolver;

require __DIR__ . DIRECTORY_SEPARATOR . "vendor/autoload.php";

if (count($argv) < 2) {
    exit("[ERROR] Invalid command" . PHP_EOL);
}


$resolver = new ReflectionResolver();
$controller = $resolver->resolve(Script::class);
$commissionFees = $controller->main($argv[1]);
print_r($commissionFees);
