<?php
if($argc != 2) die("Missing input file");

$input = file_get_contents($argv[1]);
$input = str_replace("\r", "", $input); // fixing windows
$rows = explode("\n", $input);


$partMapWidth = strlen($rows[0]);
array_push($rows, str_repeat(".", $partMapWidth));
array_unshift($rows, str_repeat(".", $partMapWidth));

$partMap = [];
foreach($rows as $key=>$row) {
    $partMapRow = [];
    $partMapRow[] = ".";

    $currentNumber = "";
    for($i=0; $i < $partMapWidth; $i++) {
        $currentChar = substr($row, $i, 1);

        if($currentChar == ".") {
            $partMapRow[] = ".";
            $currentNumber = "";
            continue;
        }

        if($currentChar == "*") {
            $partMapRow[] = "*";
            $currentNumber = "";
            continue;
        }

        if(!is_numeric($currentChar)) {
            $partMapRow[] = "S";
            $currentNumber = "";
            continue;
        }

        if($currentNumber == "") {
            for($l=0; $l < $partMapWidth-$i; $l++) {
                $additionalChar = substr($row, $i+$l, 1);
                if(!is_numeric($additionalChar)) {
                    break;
                }

                $currentNumber.= $additionalChar;
            }
        }

        $partMapRow[] = $currentNumber;
    }

    $partMapRow[] = ".";
    $partMap[] = $partMapRow;
}

$partSum = 0;
foreach($partMap as $rowNumber=>$partMapRow) {
    $hit = false;
    foreach($partMapRow as $cellNumber=>$content) {
        if(!is_numeric($content)) {
            $hit = false;
        }

        if(is_numeric($content) && !$hit) {
            if(in_array($partMap[$rowNumber-1][$cellNumber-1], ["S", "*"])) $hit = true;
            if(in_array($partMap[$rowNumber-1][$cellNumber], ["S", "*"])) $hit = true;
            if(in_array($partMap[$rowNumber-1][$cellNumber+1], ["S", "*"])) $hit = true;

            if(in_array($partMap[$rowNumber][$cellNumber-1], ["S", "*"])) $hit = true;
            if(in_array($partMap[$rowNumber][$cellNumber], ["S", "*"])) $hit = true;
            if(in_array($partMap[$rowNumber][$cellNumber+1], ["S", "*"])) $hit = true;

            if(in_array($partMap[$rowNumber+1][$cellNumber-1], ["S", "*"])) $hit = true;
            if(in_array($partMap[$rowNumber+1][$cellNumber], ["S", "*"])) $hit = true;
            if(in_array($partMap[$rowNumber+1][$cellNumber+1], ["S", "*"])) $hit = true;

            if($hit) {
                $partSum+= intval($content);
                echo " -hit";
            } else {
                echo " -miss";
            }
        }
    }
}


echo "\n\n";
echo "Solution for Part One: {$partSum}";
echo "\n\n";

$gearSum = 0;
foreach($partMap as $rowNumber=>$partMapRow) {
    $hits = [];
    foreach($partMapRow as $cellNumber=>$content) {
        if($content != "*") {
            $hits = [];
        }

        if($content == "*" && !$hits) {
            if(is_numeric($partMap[$rowNumber-1][$cellNumber-1])) $hits[] = $partMap[$rowNumber-1][$cellNumber-1];
            if(is_numeric($partMap[$rowNumber-1][$cellNumber])) $hits[] = $partMap[$rowNumber-1][$cellNumber];
            if(is_numeric($partMap[$rowNumber-1][$cellNumber+1])) $hits[] = $partMap[$rowNumber-1][$cellNumber+1];

            if(is_numeric($partMap[$rowNumber][$cellNumber-1])) $hits[] = $partMap[$rowNumber][$cellNumber-1];
            if(is_numeric($partMap[$rowNumber][$cellNumber])) $hits[] = $partMap[$rowNumber][$cellNumber];
            if(is_numeric($partMap[$rowNumber][$cellNumber+1])) $hits[] = $partMap[$rowNumber][$cellNumber+1];

            if(is_numeric($partMap[$rowNumber+1][$cellNumber-1])) $hits[] = $partMap[$rowNumber+1][$cellNumber-1];
            if(is_numeric($partMap[$rowNumber+1][$cellNumber])) $hits[] = $partMap[$rowNumber+1][$cellNumber];
            if(is_numeric($partMap[$rowNumber+1][$cellNumber+1])) $hits[] = $partMap[$rowNumber+1][$cellNumber+1];

            $hits = array_unique($hits);

            if(count($hits) == 2) {
                $gearSum+= array_product($hits);
            }
        }
    }
}


echo "\n\n";
echo "Solution for Part Two: {$gearSum}";
echo "\n\n";