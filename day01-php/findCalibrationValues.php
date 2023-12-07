<?php
if($argc != 2) die("Missing input file");

$input = file_get_contents($argv[1]);
$input = str_replace("\r", "", $input); // fixing windows
$instructions = explode("\n", $input);

$calibrationSum = 0;
foreach($instructions as $instruction) {
    preg_match("/^\w*?(?'FIRST_DIGIT'\d).*(?'LAST_DIGIT'\d)\w*?$/", $instruction, $matches);
    if(array_key_exists("FIRST_DIGIT", $matches) && array_key_exists("LAST_DIGIT", $matches)) {
        $calibrationSum+= 10*intval($matches["FIRST_DIGIT"])+intval($matches["LAST_DIGIT"]);
    } else {
        preg_match("/(?'FIRST_DIGIT'\d)/", $instruction, $matches);
        if (array_key_exists("FIRST_DIGIT", $matches)) {
            $calibrationSum+= 10*intval($matches["FIRST_DIGIT"])+intval($matches["FIRST_DIGIT"]);
        }
    }
}

echo "\n\n";
echo "Solution for Part One: {$calibrationSum}";
echo "\n\n";