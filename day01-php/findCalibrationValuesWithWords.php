<?php
if($argc != 2) die("Missing input file");

$input = file_get_contents($argv[1]);
$input = str_replace("\r", "", $input); // fixing windows
$instructions = explode("\n", $input);

$calibrationSum = 0;
foreach($instructions as $instruction) {
    preg_match("/^\w*?(?'FIRST_DIGIT'(\d|one|two|three|four|five|six|seven|eight|nine)).*(?'LAST_DIGIT'(\d|one|two|three|four|five|six|seven|eight|nine))\w*?$/", $instruction, $matches);
    if(array_key_exists("FIRST_DIGIT", $matches) && array_key_exists("LAST_DIGIT", $matches)) {
        $calibrationSum+= 10*intmap($matches["FIRST_DIGIT"])+intmap($matches["LAST_DIGIT"]);
    } else {
        preg_match("/(?'FIRST_DIGIT'(\d|one|two|three|four|five|six|seven|eight|nine))/", $instruction, $matches);
        if (array_key_exists("FIRST_DIGIT", $matches)) {
            $calibrationSum+= 10*intmap($matches["FIRST_DIGIT"])+intmap($matches["FIRST_DIGIT"]);
        }
    }
}

echo "\n\n";
echo "Solution for Part Two: {$calibrationSum}";
echo "\n\n";

function intmap($value) {
    switch($value) {
        case "one":
            return 1;
        case "two":
            return 2;
        case "three":
            return 3;
        case "four":
            return 4;
        case "five":
            return 5;
        case "six":
            return 6;
        case "seven":
            return 7;
        case "eight":
            return 8;
        case "nine":
            return 9;
        default:
            return intval($value);
    }
}