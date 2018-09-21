<?
if (!isset($argv[1])){
	echo "Вы ничего не ввели\n";
	die();
}

$array = [
	"country" => $argv[1]
];

$readFile = file("visa.csv");
$countryInput = "";
$shortest = -1;

function utf8_to_extended_ascii($str, &$map)
{
    $matches = array();
    if (!preg_match_all('/[\xC0-\xF7][\x80-\xBF]+/', $str, $matches))
        return $str;

    foreach ($matches[0] as $mbc)
    {
        if (!isset($map[$mbc]))
        {
            $map[$mbc] = chr(128 + count($map));
        }
	}
    return strtr($str, $map);
}

function levenshtein_utf8($s1, $s2)
{
    $charMap = array();
    $s1 = utf8_to_extended_ascii($s1, $charMap);
    $s2 = utf8_to_extended_ascii($s2, $charMap);
    return levenshtein($s1, $s2);
}

foreach ($readFile as $data) {
	$arRow = str_getcsv($data);
    $lev = levenshtein_utf8($array["country"],$arRow[1]);
    // $lev = levenshtein($array["country"],$arRow[1]);

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
} elseif ($shortest <= 2) {
    echo "Если вы имелли в виду: $closest, то там $countryInput\n";
} else {
	echo "\nНет такой страны!";
}  

?>