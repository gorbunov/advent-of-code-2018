<?php declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';

/** @var string[] $input */
$input = file(__DIR__.'/../input/input02.txt', FILE_IGNORE_NEW_LINES);

# solution part 01
$filtering = static fn(string $label, int $matchCount): bool => \in_array($matchCount, array_count_values(\str_split($label)));
$filtering3 = static fn(string $label): bool => $filtering($label, 3);
$filtering2 = static fn(string $label): bool => $filtering($label, 2);

$has3 = array_filter($input, $filtering3);
$has2 = array_filter($input, $filtering2);
$checksum = count($has2) * count($has3);

print "Checksum 01: ${checksum}\n";

# solution part 02

$preview = static fn(string $string): string => implode(" ", str_split($string, 3));

$comparable = static function (string $firstLabel, string $secondLabel): bool {
    $firstLabelChars = str_split($firstLabel);
    $secondLabelChars = str_split($secondLabel);
    $mistakes = 0;
    foreach ($firstLabelChars as $position => $char) {
        if ($char !== $secondLabelChars[$position]) {
            $mistakes++;
        }
    }
    return $mistakes === 1;
};

$labelsCount = count($input);
for ($fi = 0; $fi < $labelsCount; $fi++) {
    for ($si = $fi; $si < $labelsCount; $si++) {
        if ($comparable($input[$fi], $input[$si])) {
            print "Matching boxes $fi, $si: \n".$preview($input[$fi])."\n".$preview($input[$si])."\n".implode(array_intersect_assoc(str_split($input[$fi]), str_split($input[$si])))."\n";
        }
    }
}