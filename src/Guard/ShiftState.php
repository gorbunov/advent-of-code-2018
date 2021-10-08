<?php declare(strict_types=1);


namespace Guard;


use JetBrains\PhpStorm\Pure;

final class ShiftState
{
    public const STATE_AWAKE = 1;
    public const STATE_ASLEEP = 2;
    private int $state;
    private int $start;
    private int $length;

    public function __construct(int $state, int $start, int $length)
    {
        $this->state = $state;
        $this->start = $start;
        $this->length = $length;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    public function __toString(): string
    {
        return $this->isAsleep() ? 'WAS ASLEEP; ' : 'WAS AWAKE; ';
    }

    public function isAsleep(): bool
    {
        return $this->state === self::STATE_ASLEEP;
    }

    #[Pure]
    public function getMinutesRange(): array
    {
        return range($this->getStart(), $this->getStart() + $this->getLength() -1);
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }
}