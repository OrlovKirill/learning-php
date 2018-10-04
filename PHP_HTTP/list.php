<?php
$file_list = glob('tests/*.json');

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>list.php</title>
</head>
<body>
	<?php foreach ($file_list as $item): ?>
		<?php 	$file = str_replace('tests/', '', $item); ?> 
		
		<h2> <a href="tests.php?id=<?php echo (int) filter_var($file, FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo ($file); ?></h2> </a></br> 	
	<?php endforeach ;?>
	<ul>
        <li><a href="admin.php">Загрузить тест</a></li>
    </ul>
</body>
</html>