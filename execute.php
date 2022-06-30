<?php
require './vendor/autoload.php';

if(isset($argv[1])) {
    $command = $argv[1];
} else {
    echo "Please give a command name";
    exit;
}


$commandSanitized = "App\Console\\".ucfirst($command);

try {
    $shiftedArr = $argv;
    unset($shiftedArr[0]);
    unset($shiftedArr[1]);
    (new $commandSanitized(array_values($shiftedArr)))->handle();
} catch(Exception $e) {
    echo "Something went wrong";
    exit;
}
