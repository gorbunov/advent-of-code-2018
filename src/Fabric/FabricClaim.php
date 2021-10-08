<?php declare(strict_types=1);


namespace Fabric;


final class FabricClaim
{
    private int $id;
    private Point2D $startingPosition;
    private Area $area;

    private function __construct(int $id, Point2D $startingPosition, Area $area)
    {
        $this->id = $id;
        $this->startingPosition = $startingPosition;
        $this->area = $area;
    }

    public static function parse(string $claim)
    {
        preg_match('~^#(\d+)\s@\s(\d+),(\d+):\s(\d+)x(\d+)$~', $claim, $matches);
        unset($matches[0]);
        $matches = array_map('\intval', $matches);
        return new FabricClaim($matches[1], Point2D::create($matches[2], $matches[3]), Area::create($matches[4], $matches[5]));
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStartingPosition(): Point2D
    {
        return $this->startingPosition;
    }

    public function getArea(): Area
    {
        return $this->area;
    }

    public function getRightBottomPosition() :Point2D
    {
        return Point2D::create($this->startingPosition->getX() + $this->area->getWidth(), $this->startingPosition->getY() + $this->area->getLength());
    }
}