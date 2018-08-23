<?
$array = [
	"country" => $argv[1]
];

$readFile = file("visa.csv");
$countryInput = "";
$readFile = str_replace("\"", "", $readFile);
$shortest = -1;

foreach ($readFile as $data) {
	$arRow = explode(',', $data);
    $lev = levenshtein($array["country"],$arRow[1]);

    if ($lev == 0) {
        $closest = $arRow[1];
        $shortest = 0;
        break;
    }

    if ($lev <= $shortest || $shortest < 0) {
        $closest  = $arRow[1];
        $shortest = $lev;
        $countryInput = $arRow[4];
    }
}

if ($shortest == 0) {
		$countryInput = $arRow[4];
		$result = ("\n".$array["country"].": ".$countryInput);
    	echo ($result);
} elseif ($shortest <= 3) {
    echo "Если вы имелли в виду: $closest, то там $countryInput\n";
} else {
	echo "Нет такой страны!";
}

?>