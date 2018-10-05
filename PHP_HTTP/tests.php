<? 
$id = (int)$_GET['id'];

if (!file_exists(__DIR__.'/tests/test'.$id.'.json')){
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	exit();
};

$file_test = file_get_contents(__DIR__.'/tests/test'.$id.'.json');
$decode_file = json_decode($file_test, true);


if (isset($_POST['checkTest'])){
	$name = $_POST['username'];
	$checkTest = $_POST;
	$arAnswers = array();


 	foreach ($decode_file['questions'] as $key => $question) {
 		$arAnswers[$key] = array();
		foreach ($question['answers'] as $answer) {
			if ($answer['result']){
				$arAnswers[$key][] = $answer['text'];
			}
		}
	}
	$correctAnswers = 0;
	foreach ($arAnswers as $key => $value) {
		if (isset($checkTest['question_'.$key]) && ($checkTest['question_'.$key] == $arAnswers[$key])){
			$correctAnswers++;
		}
	}
	if ($correctAnswers == count($decode_file['questions'])){
		// $result = 'All answers are right';
        $img = imagecreatefrompng(__DIR__.'/sertificates/cover.png');
     	$textColor = imagecolorallocate($img, 0, 0, 0);
        imagettftext($img, 40, 0, 150, 350, $textColor, __DIR__.'/fonts/arial.ttf', $name.' successfully passed test N'.$id);
		header('Content-type: image/png');
        imagePng($img);
        imagedestroy($img);
	}
	elseif ($correctAnswers>0){
		$result = 'Not all questions was answered';
	}
	else {
		$result = 'No right answers';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form method="post">
			<p style="margin-bottom: 15px; font-weight: 700;">Введите ваше имя: <input type="text" name="username" required></p>
			<?php foreach($decode_file['questions'] as $qNumber => $question) :?>
				<legend style="margin-bottom: 15px; font-weight: 700;"><?=$question['question']?><br>
					<?php foreach ($question['answers'] as $answer):?>
						<label style="font-weight: 500; "><input type="checkbox" name="question_<?=$qNumber;?>[]" value="<?=$answer['text'];?>"style="margin-right:  15px; margin-top: 10px;"><?=$answer['text'];?></label>
					<? endforeach; ?>
				</legend>
			<?php endforeach; ?>
			<input type="submit" name="checkTest" value="Проверить ответы" style="margin-top:10px; font-weight: 700;">
			<?php 
			if (isset($result)){
				echo ($result); 
			}?>
	<ul>
        <li><a href="admin.php">Загрузить тест</a></li>
        <li><a href="list.php">Список тестов</a></li>
    </ul>
		
</body>
</html>


