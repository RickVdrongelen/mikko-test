<?php
namespace App\Console;

use App\Services\Payout\PayoutGenerator;
use DateTime;

class ParsePayoutCSV extends Console {
    public function handle() {
        // Check if the output directory exists
        if(!file_exists("output/")) {
            mkdir("output");
        }
        
        $input = $this->getInput();

        // The output file name is needed when starting the script, this can both be done by the first argument, or asking for user input
        if(isset($input[0])) {
            $fileName = $input[0];
        } else {
            $fileName = $this->requestUserInput("Please enter a filename for the payout file:");
        }

        $defaultYear = (new DateTime())->format("Y");
        if(isset($input[1])) {
            $year = $input[1];
        } else {
            $year = $this->requestUserInput("Please enter the year you want to generate [$defaultYear]");
        }

        if($year == "") {
            $year = $defaultYear;
        }
        
        $year = intval($year);

        // Check if the file name ends with .csv
        if(strpos($fileName, '.csv') <= 0) {
            $fileName .= '.csv';
        }

        // Check whether the file already exists, and replace if wanted
        if(file_exists('storage/'.$fileName)) {
            $replaceString = $this->requestUserInput("Given file already exists. Replace? [Y/n]");

            if($replaceString != "" || !$replaceString|| in_array($replaceString, ["Y", "y", "Yes", "yes", "Ja", "ja", "J", "j"])) {
                $replace = true;
            } else {
                echo "Failed to write to file beacuse it already exists, aborting...";
                return;
            }
        }

        $fileName = 'storage/'.$fileName;

        // We have the information needed, we can now let the generator do its work
        $payoutGenerator = new PayoutGenerator($year,["bonus" => true, "salary" => true], $fileName);
        $payoutFile = $payoutGenerator->parse();

        // echo "You can find the file at " . $fileName;
        echo "You can find the file at: " . $payoutFile->getFileLocation();
    }

    public function requestUserInput(string $question = null) {
        if(isset($question)) {
            echo $question . "\n";
        }
        $handle = fopen("php://stdin", "r");
        do { $line = fgets($handle); } while ($line === '');
        fclose($handle);
    
        // Remove the enter from the line and return the given line
        return str_replace(["\n", "\r"], '', $line);
    }
}
?>