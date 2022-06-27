<?php

class PayoutParserResult {
    public function __construct(private DateTime $currentDateTime, public DateTimeImmutable $bonusPayoutDate, public DateTimeImmutable $salaryPayoutDate) {}

    public function getMonth() : String {
        return $this->currentDateTime->format("F");
    }

    public function formatBonusDate() {
        return $this->bonusPayoutDate->format("d-m-Y");
    }

    public function formatSalaryDate() {
        return $this->salaryPayoutDate->format("d-m-Y");
    }

    public function formatSalaryDay() {
        return $this->salaryPayoutDate->format("l");
    }

    public function formatBonusDay() {
        return $this->bonusPayoutDate->format("l");
    }

    public function toString()
    {
        return "Bonus date: ". $this->bonusPayoutDate->format("l").", ". $this->bonusPayoutDate->format("d-m-Y") . "; \n Salary date: ". $this->salaryPayoutDate->format("l").", ".$this->salaryPayoutDate->format("d-m-Y") ;
    }
}