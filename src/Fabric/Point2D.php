<?php declare(strict_types=1);


namespace Fabric;


final class Point2D
{
    private int $x;
    private int $y;

    public static function create(int $x, int $y)
    {
        return new Point2D($x, $y);
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