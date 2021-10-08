<?php declare(strict_types=1);

namespace Location;

final class Position
{
    private int $x;
    private int $y;

    public static function parse(string $position)
    {
        [$x, $y] = explode(',', $position);
        return new Position((int)$x, (int)$y);
    }

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }


}