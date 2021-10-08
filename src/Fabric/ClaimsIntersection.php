<?php declare(strict_types=1);


namespace Fabric;

final class ClaimsIntersection
{
    private $area = [];

    public function applyClaim(FabricClaim $claim)
    {
        for ($x = $claim->getStartingPosition()->getX(); $x < $claim->getRightBottomPosition()->getX(); $x++) {
            for ($y = $claim->getStartingPosition()->getY(); $y < $claim->getRightBottomPosition()->getY(); $y++) {
                $this->applyPosition($x, $y);
            }
        }
    }

    private function applyPosition(int $x, int $y)
    {
        if (!\array_key_exists($x, $this->area)) {
            $this->area[$x] = [];
        }
        if (!\array_key_exists($y, $this->area[$x])) {
            $this->area[$x][$y] = 0;
        }
        $this->area[$x][$y]++;
    }

    public function intersecting(): int
    {
        $intersectingInRow = static fn(array $row) => \count(array_filter($row, static fn(int $item): bool => $item > 1));
        return array_sum(array_map($intersectingInRow, $this->area));
    }
}