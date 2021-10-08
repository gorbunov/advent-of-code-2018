<?php declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

require_once __DIR__.'/../vendor/autoload.php';

$polymer = file_get_contents(__DIR__.'/../input/input05.txt');
#$polymer = 'dabAcCaCBAcCcaDA';

function are_oppising(string $first, string $second): bool
{
    return abs(ord($first) - ord($second)) === 32;
}

#[Pure]
function collapse(string $polymer, int $position): int
{
    $first = $polymer[$position];
    $second = $polymer[$position + 1];
    $p = 0;
    while (are_oppising($first, $second)) {
        $p++;
        if (($position - $p) < 0) {
            break;
        }
        if (($position + $p + 1) >= strlen($polymer)) {
            break;
        }
        $first = $polymer[$position - $p];
        $second = $polymer[$position + 1 + $p];
    }
    return $p - 1;
}

function try_to_collapse(string $polymer, int &$startFrom): string
{
    for ($i = $startFrom; $i < strlen($polymer) - 1; $i++) {
        $collapsing = collapse($polymer, $i);
        if ($collapsing >= 0) {
            # print "Collapse by $collapsing @ $i: ";
            $start = substr($polymer, 0, $i - $collapsing);
            $finish = substr($polymer, $i + $collapsing + 2);
            $startFrom = $i - $collapsing;
            $extract = substr($polymer, $i - $collapsing, ($collapsing + 1) * 2);
            # print "$start |$extract| $finish\n";
            return $start.$finish;
        }
    }
    return $polymer;
}

function collapsed_size(string $polymer)
{
    $startFrom = 0;
    while (true) {
        $collapsed = try_to_collapse($polymer, $startFrom);
        if ($collapsed === $polymer) {
            break;
        }
        # print("$polymer to $collapsed\n");
        $polymer = $collapsed;
    }

    return strlen($polymer);
}

# solution part 01
$size = collapsed_size($polymer);
print "Most collapsed polymer size: $size\n";

#solution part 02
$shortestPolymerSize = strlen($polymer);
$bestRemovedUnit = null;

foreach (range('a', 'z') as $removed) {
    $cleanedPolymer = str_replace([$removed, strtoupper($removed)], '', $polymer);
    $collapsed_size = collapsed_size($cleanedPolymer);
    if ($collapsed_size < $shortestPolymerSize) {
        $shortestPolymerSize = $collapsed_size;
        $bestRemovedUnit = $removed;
    }
}

print "Best removed unit : $bestRemovedUnit, resulting in $shortestPolymerSize\n";