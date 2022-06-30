<?php
namespace App\Controllers;

use App\Services\Web\Request;
use App\Services\Payout\PayoutGenerator;

class HomeController extends Controller {
    public function index() {
        echo $this->renderingEngine->render('index.html');
    }

    public function calculatePayout(Request $request) {
        // Check if all the required request options are set
        $input = $request->formInput();
        $inputSet = isset($input["year"]) && isset($input["payoutTypes"]) && count($input["payoutTypes"]) > 0;

        if(!$inputSet) {
            echo "Not all required data set";
            return;
        }

        // Create and run the payout generator
        $payoutGenerator = new PayoutGenerator($input["year"], $input["payoutTypes"]);
        $payoutFile = $payoutGenerator->parse();

        echo $this->renderingEngine->render('payout.html', ['download' => $payoutFile->getDownloadUrl(), 'payoutResults' => $payoutGenerator->getOutput()]);
    }

    public function download(Request $request) {
        $query = $request->getQuery();
        if(isset($query["fileName"])) {
            $fileName = $query["fileName"];
        }
        if(!isset($fileName)) {
            echo "";
            return;
        }
        $fileName = "../storage/".$fileName;

        if(file_exists($fileName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            readfile($fileName);
            exit;
        }

        echo "File not found";
    }
}