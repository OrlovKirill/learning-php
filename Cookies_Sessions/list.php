<?php
session_start();
$file_list = glob('tests/*.json');

if ($_SESSION['login'] != true)
{
    http_response_code(403);
    header("refresh:5; url=index.php");
    echo "403! Доступ запрещен!";
    exit();
}

if (!empty($_POST['delete']) && file_exists('tests/'.$_POST['delete'])){
	unlink('tests/'.$_POST['delete']);
}	
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
				<h2><a href="tests.php?id=<?php echo (int) filter_var($file, FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo ($file); ?></h2> </a> 
				<?php if ($_SESSION['user']) :?> 	
					<form method="post"><input type="hidden" name="delete" value="<?=$file ?>"><button type="submit"> Delete </button></form></br> 
				<?php endif; ?>
		<?php endforeach ;?>
	
	<p style="padding-top:10px;"><a href="logout.php"> Выйти </a></p>

	<ul>
		<?php if ($_SESSION['user']) :?> 	
        <li><a href="admin.php">Загрузить тест</a></li>
        <?php endif; ?>
    </ul>
</body>
</html>