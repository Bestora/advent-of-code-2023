<?php
if($argc != 2) die("Missing input file");

$input = file_get_contents($argv[1]);
$input = str_replace("\r", "", $input); // fixing windows
$games = explode("\n", $input);

$limits = [
  "red" => 12,
  "green" => 13,
  "blue" => 14,
];

$sumPossibleGames = 0;
foreach($games as $game) {
    list($gameNumberString, $sets) = explode(":", $game);
    list($tmp, $gameNumber) = explode(" ", $gameNumberString);

    $sets = explode(";", $sets);
    foreach($sets as $set) {
        $cubes = explode(",", $set);
        foreach($cubes as $cube) {
            list($count, $color) = explode(" ", trim($cube));
            if($count > $limits[$color]) continue 3;
        }
    }
    // survived the continue 3, it's a possible game
    $sumPossibleGames+= intval($gameNumber);
}

echo "\n\n";
echo "Solution for Part One: {$sumPossibleGames}";
echo "\n\n";

$sumMaxSets = 0;
foreach($games as $game) {
    list($gameNumberString, $sets) = explode(":", $game);

    $maxColor = [];

    $sets = explode(";", $sets);
    foreach($sets as $set) {
        $cubes = explode(",", $set);
        foreach($cubes as $cube) {
            list($count, $color) = explode(" ", trim($cube));
            if(!array_key_exists($color, $maxColor)) $maxColor[$color] = 0;

            if($maxColor[$color] < $count) {
                $maxColor[$color] = $count;
            }
        }
    }
    // survived the continue 3, it's a possible game
    $sumMaxSets+= array_product($maxColor);
}


echo "\n\n";
echo "Solution for Part Two: {$sumMaxSets}";
echo "\n\n";