<?
include "config.php";
include "functions.php";
session_start();
$pdo = getPdo($login, $pass, $server, $db);

if (!isset($_SESSION['user'])){
    http_response_code(403);
    header("refresh:5; url=index.php");
    echo "403! Доступ запрещен!";
    exit();
}
// echo($_SESSION['id']);
// echo($_SESSION['user']);
	if(!empty($_POST['add'])){
	$description = $_POST['description'];
	$sql = "INSERT INTO task (user_id, assigned_user_id, description, is_done, date_added) VALUES (?, ?, ?, ?, now())";
	$add = $pdo->prepare($sql);
	$add->execute([$_SESSION['id'], $_SESSION['id'], $description, false]);
	header('Location: main.php');
}
// $description = $_POST['description'];
// 	$id = getData($pdo, 'login','user','id =\''.addslashes($_SESSION['id']).'\'');
// 	$resultId = $id->fetch(PDO::FETCH_ASSOC);
// 	$sql = "INSERT INTO task (user_id, assigned_user_id, description, is_done, date_added) VALUES (?, ?, ?, ?, now())";
// 	$add = $pdo->prepare($sql);
// 	$add->execute([$resultId['login'], $resultId['login'], $description, false]);
// 	header('Location: main.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href='css/style.css' rel='stylesheet' type='text/css' >
</head>
<body>
	<h1>Здравствуйте, <?=$_SESSION['user']?>! Вот ваш список дел</h1>
	<div style="float: left; margin-bottom: 20px">
		<form method="POST">
			<input type="text" name="description" placeholder="Описание задачи" value>
			<input type="submit" name="add" value="Добавить">
		</form>
	</div>

	<div style="float: left; margin-bottom: 20px">
		<form method="POST">
			<label for="sort">Сортировать по:</label>
				<select name="sortBy">
					<option value="dataCreated">дате добавления</option>
					<option value="isDone">статусу</option>
					<option value="description">описанию</option>
				</select>
			<input type="submit" name="sort" value="Отсортировать">
		</form>
	</div>
	<div style="clear:both"></div>
		<table style="border-spacing: 0">
			<tr>
				<th>Описание задачи</th>
				<th>Дата добавления</th>
				<th>Статус</th>
			<!-- 	<th></th> -->
				<th>Ответственный</th>
				<th>Автор</th>
				<!-- <th>Закрепить задачу за пользователем</th> -->
			</tr>
			<?php 
				$sql = "SELECT description, date_added, is_done, assigned_user_id, user_id, user.login, u2.login as assigned_login FROM task LEFT JOIN user ON user.id=task.user_id LEFT JOIN user as u2 ON u2.id=task.assigned_user_id WHERE user_id =".$_SESSION['id'];
				$data = $pdo->prepare($sql);
				$data->execute();
		
			?>
			<?foreach ($data as $row): ?>	
			<tr>
				<td><?= $row['description']; ?></td>
		        <td><?= $row['date_added']; ?></td>
		        <td>
		            <?php  
		            if ($row['is_done'] == 1) {
		                echo '<span style="color: green">Выполнено</span>';
		            } elseif ($row['is_done'] == 0) {
		                echo '<span style="color: red">Выполнить</span>';
		            }
		           	?>
		        </td>
		        <td><strong><?= ($row['assigned_user_id']==$_SESSION['id']) ? 'You' : $row['assigned_login'] ?></strong></td>
		        <td><strong><?= $row['login']; ?></strong></td>
		    </tr>
			<? endforeach; ?>
		</table>
	</body>
	<div style="clear:both"></div>
<footer>
	<p style="padding-top:10px;"><a href="logout.php"> Выйти </a></p>
</footer>
</html>