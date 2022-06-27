<?php

class PayoutFileHelper {
    public function __construct(private $handle) {
        $this->addHeaders();
    }

    public static function fromFileName(String $fileName) {
        $handle = fopen($fileName, "w");

        return new PayoutFileHelper($handle);
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
}