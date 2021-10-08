<?php declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';

$eventRows = file(__DIR__.'/../input/input04.txt', FILE_IGNORE_NEW_LINES);
$splitDateFn = static function (string $event, array &$collector) {
    preg_match('~^\[([^\]]+)\]\s(.*)$~', $event, $matches);
    $key = preg_replace('~([\s\-:])~', '', $matches[1]);
    $collector[(int)$key] = $matches[2];
};
$events = [];
foreach ($eventRows as $row) {
    $splitDateFn($row, $events);
}
ksort($events, SORT_ASC);

$getGuardId = static function (string $event) {
    preg_match('~\s#(\d+)\s~', $event, $matches);
    return (int)$matches[1];
};

# solution 01
$guards = new \Guard\GuardList();
/** @var \Guard\GuardShift $currentShift */
$currentShift = null;
foreach ($events as $ts => $event) {
    $minutes = (int)substr((string)$ts, -2);
    if (str_ends_with($event, 'begins shift')) {
        $currentShift?->changedState($minutes);
        $guardId = $getGuardId($event);
        $currentShift = new \Guard\GuardShift($guardId);
        $guard = $guards->getGuard($guardId);
        $guard->addShift($currentShift);
    } else {
        $currentShift->changedState($minutes);
    }
}
$currentShift->changedState(60);

$mostAsleepGuard = $guards->mostAsleep();
$bestMinuteAsleep = $mostAsleepGuard->mostSleepyAt();
print "Good at #".$mostAsleepGuard->getGuardId()." x ".$bestMinuteAsleep." = ".$bestMinuteAsleep * $mostAsleepGuard->getGuardId()."\n";