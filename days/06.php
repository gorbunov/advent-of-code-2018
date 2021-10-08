<?php declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';
$coords = file(__DIR__.'/../input/input06.txt', FILE_IGNORE_NEW_LINES);
$coords = array_map(fn(string $coord) => \Location\Position::parse($coord), $coords);