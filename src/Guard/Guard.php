<?php declare(strict_types=1);


namespace Guard;


final class Guard
{
    private int $guardId;
    /** @var GuardShift[] */
    private array $shifts;

    public function __construct(int $guardId)
    {
        $this->guardId = $guardId;
    }

    /**
     * @return int
     */
    public function getGuardId(): int
    {
        return $this->guardId;
    }

    public function addShift(GuardShift $shift)
    {
        $this->shifts[] = $shift;
    }

    public function timeAsleep(): int
    {
        $asleep = 0;
        foreach ($this->shifts as $shift) {
            $asleep += $shift->timeAsleep();
        }
        return $asleep;
    }

    public function mostSleepyAt(): int
    {
        $sleepyAt = $this->getSleepyMinutes();
        $maxAsleep = 0;
        $minuteAsleep = 0;
        foreach ($sleepyAt as $minute => $timesAsleep) {
            if ($timesAsleep > $maxAsleep) {
                $maxAsleep = $timesAsleep;
                $minuteAsleep = $minute;
            }
        }

        return $minuteAsleep;
    }

    public function __toString(): string
    {
        $string = "Guard #".$this->guardId."\n";
        foreach ($this->shifts as $shift) {
            $string .= (string)$shift;
        }
        return $string;
    }

    public function getSleepsAtSameMinute()
    {
        $sleepyMinutes = $this->getSleepyMinutes();
        return empty($sleepyMinutes) ? 0 : max($sleepyMinutes);
    }

    /**
     * @return array
     */
    private function getSleepyMinutes(): array
    {
        $sleepyAt = [];
        foreach ($this->shifts as $shift) {
            $sleptAtShiftInMinutes = $shift->sleptAtMinutes();
            $sleepyAt = [...$sleepyAt, ...$sleptAtShiftInMinutes];
        }
        $sleepyAt = array_count_values($sleepyAt);
        return $sleepyAt;
    }

    public function sleepiestMinute(): int
    {
        $sleepiestMinute = 0;
        $maxSleepiestCount = 0;
        foreach ($this->getSleepyMinutes() as $minute => $count) {
            if ($count > $maxSleepiestCount) {
                $maxSleepiestCount = $count;
                $sleepiestMinute = $minute;
            }
        }
        return $sleepiestMinute;
    }
}