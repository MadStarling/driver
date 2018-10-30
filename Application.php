<?php 
require __DIR__.'/vendor/autoload.php';

function run($politicController){
    $politicController->printResults();
}

$file = "/../filesToRead/simple.txt";

echo "FCFS\n";
$FCFSController = new Politics\FCFS($file);
run($FCFSController);
echo "\n";

echo "Scan\n";
$FCFSController = new Politics\Scan($file);
run($FCFSController);