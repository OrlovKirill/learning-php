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
		<h2> <?php echo ($file); ?></h2> </br> 	
	<?php endforeach ;?>
	<ul>
        <li><a href="admin.php">Загрузить тест</a></li>
    </ul>
</body>
</html>