<?php
// Require all neccessary classes
require_once('services/payout/PayoutParser.php');
require_once('services/payout/PayoutFileHelper.php');

// Check if the output directory exists
if(!file_exists("output/")) {
    mkdir("output");
}

// The output file name is needed when starting the script, this can both be done by the first argument, or asking for user input
if(isset($argv[1])) {
    $fileName = $argv[1];
} else {
    $fileName = requestUserInput("Please enter a filename for the payout file:");
}

// Check if the file name ends with .csv
if(strpos($fileName, '.csv') <= 0) {
    $fileName .= '.csv';
}

// Check whether the file already exists, and replace if wanted
if(file_exists('output/'.$fileName)) {
    $replaceString = requestUserInput("Given file already exists. Replace? [Y/n]");

    if($replaceString != "" || !$replaceString|| in_array($replaceString, ["Y", "y", "Yes", "yes", "Ja", "ja", "J", "j"])) {
        $replace = true;
    } else {
        echo "Failed to write to file beacuse it already exists, aborting...";
        return;
    }
}

$fileName = 'output/'.$fileName;

// We have the information needed, we can now start a while loop with the payout parser to get the required output to the console and a file
$payoutOutputParser = new PayoutParser();
$payoutFileHelper = PayoutFileHelper::fromFileName($fileName);


while(!$payoutOutputParser->finished()) {
    $payoutOutputParser = $payoutOutputParser->next();

    // $output is a PayoutParserResult object, that way the PayoutFile has a standard class to handle
    $output = $payoutOutputParser->getOutput();
    $payoutFileHelper->saveDate($output);

    // Output the result to the console
    echo "Parsing dates: \n ". $output->toString() . "\n";
}

echo "You can find the file at " . $fileName;

function requestUserInput(string $question = null) {
    if(isset($question)) {
        echo $question . "\n";
    }
    $handle = fopen("php://stdin", "r");
    do { $line = fgets($handle); } while ($line === '');
    fclose($handle);

    // Remove the enter from the line and return the given line
    return str_replace(["\n", "\r"], '', $line);
}
?>