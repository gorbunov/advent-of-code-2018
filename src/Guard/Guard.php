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
        $sleepyAt = [];
        foreach ($this->shifts as $shift)
        {
            $sleptAtShiftInMinutes = $shift->sleptAtMinutes();
            $sleepyAt = [...$sleepyAt, ...$sleptAtShiftInMinutes];
        }
        var_dump(array_count_values($sleepyAt));
        return 0;
    }

    public function __toString(): string
    {
        $string = "Guard #".$this->guardId."\n";
        foreach ($this->shifts as $shift) {
            $string .= (string)$shift;
        }
        return $string;
    }
}