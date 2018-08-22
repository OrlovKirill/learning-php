<?
$options = getopt("", ["today::"]);
if (isset($options["today"])){
	$readFile = file("data.csv");
	$sum = 0;
	foreach ($readFile as $data) {
		$arRow = explode(',', $data);		
		if ($arRow[0] == date('d.m.Y')){
			$sum += $arRow[1];
		}
	}
	echo date('d.m.Y'). " расход за день: ".number_format($sum,2,".","");
} else{
	if (floatval($argv[1])<= 0){
		echo 'Ошибка! Вы ввели неверную цену.';
	} else {
		$array = [
			"date" => date('d.m.Y'),
			"cost" => number_format($argv[1],2,".",""),
			"name" =>  implode(" ", array_slice($argv, 2))
		];  
		if (strlen($array["cost"]) == 0 || empty($array["name"]))  {  
			echo "Ошибка! Аргументы не заданы. Укажите флаг --today или запустите скрипт с аргументами {цена} и {описание покупки}";
		} else {
			$result = fopen ("data.csv", "a");
			$row = $array['date'].', '. $array["cost"]. ', ' . $array["name"];
			fwrite($result,  $row. "\n");
			fclose($result);
			echo "Добавлена строка: $row";
		}
	}
}

?>