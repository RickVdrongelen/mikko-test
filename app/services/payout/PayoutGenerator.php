<?php
namespace App\Services\Payout;

use DateTime;

class PayoutGenerator {
    private PayoutParser $payoutParser;
    private PayoutFileHelper $payoutFileHelper;

    private array $output = [];

    public function __construct(private int $year, private array $payoutTypes, private ?string $fileName = null) {
        $this->payoutParser = new PayoutParser(DateTime::createFromFormat("Y-m-d", $year."-01-01"), isset($this->payoutTypes["bonus"]), isset($this->payoutTypes["salary"]));
        $this->payoutFileHelper = PayoutFileHelper::fromFileName($fileName ?? "../storage/payout-{$this->year}-file.csv");
    }

    public function parse() : PayoutFileHelper {
        while(!$this->payoutParser->finished()) {
            $payoutOutputParser = $this->payoutParser->next();
        
            // $output is a PayoutParserResult object, that way the PayoutFile has a standard class to handle
            $output = $payoutOutputParser->getOutput();
            $this->output[] = ["month" => $output->getMonth(), "bonusDate" => $output->formatBonusDate(), "salaryDate" => $output->formatSalaryDate(), "bonusDay" => $output->formatBonusDay(), "salaryDay" => $output->formatSalaryDay()];
            $this->payoutFileHelper->saveDate($output);
        }

        return $this->payoutFileHelper;
    }

    public function getOutput() {
        return $this->output;
    }
}