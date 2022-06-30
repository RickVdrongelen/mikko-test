<?php
namespace App\Services\Payout;

use DateTime;
use DateTimeImmutable;

class PayoutParserResult {
    public function __construct(private DateTime $currentDateTime, public ?DateTimeImmutable $bonusPayoutDate = null, public ?DateTimeImmutable $salaryPayoutDate = null) {}

    public function getMonth() : String {
        return $this->currentDateTime->format("F");
    }

    public function formatBonusDate() {
        return isset($this->bonusPayoutDate) ? $this->bonusPayoutDate->format("d-m-Y") : "";
    }

    public function formatSalaryDate() {
        return isset($this->salaryPayoutDate) ? $this->salaryPayoutDate->format("d-m-Y") : "";
    }

    public function formatSalaryDay() {
        return isset($this->salaryPayoutDate) ? $this->salaryPayoutDate->format("l") : "";
    }

    public function formatBonusDay() {
        return isset($this->bonusPayoutDate) ? $this->bonusPayoutDate->format("l"): "";
    }

    public function toString()
    {
        return "Bonus date: ". $this->bonusPayoutDate->format("l").", ". $this->bonusPayoutDate->format("d-m-Y") . "; \n Salary date: ". $this->salaryPayoutDate->format("l").", ".$this->salaryPayoutDate->format("d-m-Y") ;
    }
}