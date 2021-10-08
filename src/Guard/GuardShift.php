<?php declare(strict_types=1);


namespace Guard;


final class GuardShift
{
    private int $guardId;
    private int $currentEventStart = 0;
    private int $currentEventState = ShiftState::STATE_AWAKE;
    /** @var ShiftState[] */
    private array $states = [];

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

    public function changedState(int $min): void
    {
        $this->recordState($min);
        $this->currentEventStart = $min;
        $this->toggleCurrentState();
    }

    private function recordState(int $min): void
    {
        $this->states[] = new ShiftState($this->currentEventState, $this->currentEventStart, $this->elapsed($min));
    }

    private function elapsed(int $min): int
    {
        return $min - $this->currentEventStart;
    }

    private function toggleCurrentState(): void
    {
        $this->currentEventState = $this->currentEventState === ShiftState::STATE_AWAKE ? ShiftState::STATE_ASLEEP : ShiftState::STATE_AWAKE;
    }

    public function timeAsleep(): int
    {
        $asleep = 0;
        foreach ($this->states as $state) {
            if ($state->isAsleep()) {
                $asleep += $state->getLength();
            }
        }
        return $asleep;
    }

    public function __toString(): string
    {
        $repr = '';
        foreach ($this->states as $state) {
            $repr .= '[ '.$state->getStart().','.$state->getLength().' ]'.(string)$state;
        }
        return $repr."\n";
    }

    public function sleptAtMinutes() : array
    {
        $minutes = [];
        foreach ($this->states as $state) {
            if ($state->isAsleep()) {
                $minutes = [...$minutes, ...$state->getMinutesRange()];
            }
        }
        return $minutes;
    }
}