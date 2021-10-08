<?php declare(strict_types=1);


namespace Guard;


final class GuardList
{
    /** @var Guard[] */
    private $guards = [];

    public function getGuard(int $id): Guard
    {
        if (!\array_key_exists($id, $this->guards)) {
            $this->guards[$id] = new Guard($id);
        }
        return $this->guards[$id];
    }

    public function mostAsleep(): Guard
    {
        $max = 0;
        $mostSleepyGuard = null;
        foreach ($this->guards as $guard) {
            $guardAsleepTotal = $guard->timeAsleep();
            # print "Guard #".$guard->getGuardId()." was asleep ${guardAsleepTotal} minutes\n";
            if ($guardAsleepTotal > $max) {
                $max = $guardAsleepTotal;
                $mostSleepyGuard = $guard;
            }
        }
        return $mostSleepyGuard;
    }

    public function getSleepConsistentGuard(): Guard
    {
        $maxConsistency = 0;
        $mostConsistentSleeper = null;
        foreach ($this->guards as $guard) {
            $maxTimes = $guard->getSleepsAtSameMinute();
            if ($maxTimes > $maxConsistency) {
                $maxConsistency = $maxTimes;
                $mostConsistentSleeper = $guard;
            }
        }

        return $mostConsistentSleeper;
    }
}