<?php
ini_set('memory_limit', '-1');

if($argc != 2) die("Missing input file");

$input = file_get_contents($argv[1]);
$input = str_replace("\r", "", $input); // fixing windows
$cards = explode("\n", $input);
$cardWinLookup = [];

$sumPoints = 0;
foreach($cards as $cardNr=>$card) {
    list($tmp, $numbers) = explode(":", $card);
    list($winningNumbers, $cardNumbers) = explode("|", $numbers);

    $winningNumbers = explode(" ", $winningNumbers);
    $winningNumbersLookup = [];
    foreach($winningNumbers as $number) {
        $number = intval(trim($number));
        if(!$number) continue;

        $winningNumbersLookup[$number] = $number;
    }

    $countWinningNumbers = 0;
    $cardNumbers = explode(" ", $cardNumbers);
    foreach($cardNumbers as $number) {
        $number = intval(trim($number));
        if(!$number) continue;

        if(array_key_exists($number, $winningNumbersLookup)) {
            $countWinningNumbers++;
        }
    }
    if($countWinningNumbers) {
        $sumPoints+= pow(2, $countWinningNumbers-1);
    }

    $cardWinLookup[$cardNr] = $countWinningNumbers;
}


echo "\n\n";
echo "Solution for Part One: {$sumPoints}";
echo "\n\n";

$cardPile = [];
for($i=0; $i < count($cards); $i++) {
    $cardPile[] = $i;
}

for($i = 0; $i < count($cardPile); $i++) {
    $cardNr = $cardPile[$i];

    $countWinningNumbers = $cardWinLookup[$cardNr];

    for($c=1; $c<=$countWinningNumbers; $c++) {
        if($cardNr+$c < count($cards)) {
            $cardPile[] = $cardNr+$c;
        }
    }
}

echo "\n\n";
echo "Solution for Part Two: ".count($cardPile);
echo "\n\n";
