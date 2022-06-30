<?php
namespace App\Services\Payout;

use DateInterval;
use DateTime;
use DateTimeImmutable;

class PayoutParser {
    private DateTime $currentDateTime;
    private DateTimeImmutable $bonusPayoutDate;
    private DateTimeImmutable $salaryPayoutDate;

    private bool $firstRun = true;
    
    public function __construct(
        private ?DateTime $startDateTime = null, 
        private bool $bonus = true,
        private bool $salary = true
    ) {
        $current = new DateTime();
        
        if(!isset($this->startDateTime)) {
            // Set the date time to the first of januari in the current year
            $this->startDateTime = new DateTime();
            $this->startDateTime->setDate((int)$current->format("Y"), 1, 1)->setTime(0,0,0);
        }

        // Set the current date to the start date
        $this->currentDateTime = $this->startDateTime;
    }

    public function finished() : bool {
        return $this->currentDateTime->format("m") == 12;
    }

    public function next() : static {
        if(!$this->firstRun) {
            // If the latest payout type was salary, set the current date to the first day of the next month
            $this->currentDateTime = $this->currentDateTime->setDate($this->currentDateTime->format("Y"), $this->currentDateTime->format("m")+1, 1);
        }

        $salaryPayoutDate = $this->getSalaryPayoutDate();
    
        if($this->bonus) {
            $this->bonusPayoutDate = $this->getBonusPayoutDate();
        }

        if($this->salary) {
            $this->salaryPayoutDate = $salaryPayoutDate;
        }

        $this->currentDateTime = DateTime::createFromImmutable($salaryPayoutDate);
        $this->firstRun = false;

        return $this;
    }

    public function getOutput() : PayoutParserResult {
        return new PayoutParserResult($this->currentDateTime, $this->bonus ? $this->bonusPayoutDate : null, $this->salary ? $this->salaryPayoutDate : null);
    }

    private function getBonusPayoutDate() : DateTimeImmutable {
        $latestPayoutDate = $this->currentDateTime;
        // Go the the 15 day of the current month
        $bonusPayoutDate = $latestPayoutDate->setDate($latestPayoutDate->format("Y"), $latestPayoutDate->format("m"), 15);

        // Check if the bonus payout date falls in a weekend. If it is we should go the the next wednesday
        if($this->isWeekend($bonusPayoutDate)) {
            // To go to wednesday from sunday is 3 days, so that makes 10
            // Subtract the iso date of the weekend, and we have the number of days we should add to get to wednesday
            $addNumber = 10 - (int)$bonusPayoutDate->format("N");
            // The bonus payout date must now be the next Wednesday
            $bonusPayoutDate = $bonusPayoutDate->add(new DateInterval("P".$addNumber."D"));
        }

        return DateTimeImmutable::createFromMutable($bonusPayoutDate);
    }

    private function getSalaryPayoutDate() {
        $latestPayoutDate = $this->currentDateTime;
        // Go the the last day of the month, t is in DateTime the amount of days in the month, so also the latest date
        $salaryPayoutDate = $latestPayoutDate->setDate($latestPayoutDate->format("Y"), $latestPayoutDate->format("m"), $latestPayoutDate->format("t"));
        
        // Check if the salary payout date falls in a weekend. When it does, we should set the salary payout date to the latest workday
        if($this->isWeekend($salaryPayoutDate)) {
            // The latest workday is 5 (Friday), so subtract 5 from the current date, and then we know how much we should subtract from the current
            $subNumber = (int)$salaryPayoutDate->format("N") - 5;
            $salaryPayoutDate = $salaryPayoutDate->sub(new DateInterval("P".$subNumber."D"));
        }

        return DateTimeImmutable::createFromMutable($salaryPayoutDate);
    }

    /**
     *  Get the ISO8601 day integer out of the payout date. 
     *  That way we can check if the bonus payout date is day that falls in the weekend
     *  We can check using by asserting that the day is higher than 5. The ISO8601 day starts at 1(Monday) and ends at 7(Sunday)
     *  So 5 is a friday, and everything higher must be a weekend day
     *
     * @param DateTime $payoutDate
     * @return boolean
     */
    private function isWeekend(DateTime $payoutDate) {
        return $payoutDate->format("N") > 5;
    }
}