<?php
namespace App\Services\Payout;


class PayoutFileHelper {
    public function __construct(private $handle, private string $fileName) {
        $this->addHeaders();
    }

    public static function fromFileName(String $fileName) {
        $handle = fopen($fileName, "w");

        return new PayoutFileHelper($handle, $fileName);
    }

    public function saveDate(PayoutParserResult $time) 
    {
        return fputcsv($this->handle, [
            $time->getMonth(),
            $time->formatBonusDate(),
            $time->formatSalaryDate(),
            $time->formatBonusDay(),
            $time->formatSalaryDay()
        ]);
    }

    private function addHeaders() {
        fputcsv($this->handle, [
            'Month name', 'Bonus date', 'Salary Date', 'Bonus Day', 'Salary Day'
        ]);
    }

    public function getDownloadUrl() {
        return 'download?fileName='.str_replace("../storage/", "", $this->fileName);
    }

    public function getFileLocation() {
        return "{$this->fileName}";
    }
}