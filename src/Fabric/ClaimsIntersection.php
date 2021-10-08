<?php declare(strict_types=1);


namespace Fabric;

final class ClaimsIntersection
{
    private $area = [];
    private $dirtyClaims = [];
    private $appliedClaims = [];

    public function applyClaim(FabricClaim $claim)
    {
        for ($x = $claim->getStartingPosition()->getX(); $x < $claim->getRightBottomPosition()->getX(); $x++) {
            for ($y = $claim->getStartingPosition()->getY(); $y < $claim->getRightBottomPosition()->getY(); $y++) {
                $this->applyPosition($x, $y, $claim->getId());
            }
        }
    }


    private function applyPosition(int $x, int $y, int $claimId)
    {
        $this->appliedClaims[$claimId] = $claimId;
        if (!\array_key_exists($x, $this->area)) {
            $this->area[$x] = [];
        }
        if (!\array_key_exists($y, $this->area[$x])) {
            $this->area[$x][$y] = 0;
        }
        $possibleClaimId = $this->area[$x][$y];
        if ($possibleClaimId > 0) { # existing claim
            $this->dirtyClaims[$possibleClaimId] = $possibleClaimId;
            $this->area[$x][$y] = -1;
        }
        if ($this->area[$x][$y] === 0) { # fresh claim
            $this->area[$x][$y] = $claimId;
        }
    }

    public function intersecting(): int
    {
        $intersectingInRow = static fn(array $row) => \count(array_filter($row, static fn(int $item): bool => $item === -1));
        return array_sum(array_map($intersectingInRow, $this->area));
    }

    /**
     * @return array
     */
    public function getDirtyClaims(): array
    {
        return $this->dirtyClaims;
    }

    /**
     * @return array
     */
    public function getAppliedClaims(): array
    {
        return $this->appliedClaims;
    }

    /**
     * @param FabricClaim[] $claims
     *
     * @return FabricClaim
     */
    public function findCleanClaim(array $claims): FabricClaim
    {
        $areas = $this->getTakenAreas();
        foreach ($claims as $claim) {
            if ($this->isCleanClaim($claim, $areas)) {
                return $claim;
            }
        }
        throw new \RuntimeException("No suitiable claims were found");
    }

    private function getTakenAreas()
    {
        $claimedAreas = [];
        foreach ($this->area as $row) {
            $rowSingleClaimedInches = array_filter($row, static fn(int $claimId) => $claimId > 0);
            foreach ($rowSingleClaimedInches as $singleClaimedInch) {
                if (!\array_key_exists($singleClaimedInch, $claimedAreas)) {
                    $claimedAreas[$singleClaimedInch] = 0;
                }
                $claimedAreas[$singleClaimedInch]++;
            }
        }

        return $claimedAreas;
    }

    private function isCleanClaim(FabricClaim $claim, array $takenAreas): bool
    {
        if (!\array_key_exists($claim->getId(), $takenAreas)) {
            return false;
        }
        if (\in_array($claim->getId(), $this->dirtyClaims, true)) {
            return false;
        }
        return $claim->getAreaDefinition()->size() === $takenAreas[$claim->getId()];
    }
}