<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

$claims = file(__DIR__ . '/../input/input03.txt', FILE_IGNORE_NEW_LINES);
$claims = array_map(static fn(string $claim) => \Fabric\FabricClaim::parse($claim), $claims);

# solution part 01

$claimIntersector = new \Fabric\ClaimsIntersection();
foreach ($claims as $claim) {
    $claimIntersector->applyClaim($claim);
}

print "Intersecting positions: ". $claimIntersector->intersecting(). "\n";

# solution part 02

print "Unaffecting claim id: " . $claimIntersector->findCleanClaim($claims)->getId() . "\n";