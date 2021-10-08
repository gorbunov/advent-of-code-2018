<?php declare(strict_types=1);

$freqChanges = array_map("\intval", file(__DIR__.'/../input/input01.txt', FILE_IGNORE_NEW_LINES));

# part 1 solution
$freq = array_reduce($freqChanges, static fn($carry, $freqChange) => $carry + $freqChange, 0);

print "Frequency 01: ${freq}\n";

# part 2 solution
$freq = 0;
$foundFrequencies = [$freq];
while(true) {
    foreach ($freqChanges as $freqChange) {
        $freq+= $freqChange;
        if (\in_array($freq, $foundFrequencies, true)) {
            break 2;
        }
        $foundFrequencies[] = $freq;
    }
}
print "Frequency 02: ${freq}\n";