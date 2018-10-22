<?
session_start();

if (!isset($_SESSION['user'])){
    http_response_code(403);
    header("refresh:5; url=index.php");
    echo "403! Доступ запрещен!";
    exit();
}

// SELECT description, date_added, is_done, assigned_user_name, author_name FROM task WHERE assigned_user_name = $_SESSION['user']

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Здравствуйте, <?=$_SESSION['user']?>!Вот ваш список дел</h1>
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
	<table>
		<tr>
			<th>Описание задачи</th>
			<th>Дата добавления</th>
			<th>Статус</th>
			<th></th>
			<th>Ответственный</th>
			<th>Автор</th>
			<!-- <th>Закрепить задачу за пользователем</th> -->
		</tr>
		
		<tr>
			<td><?= $['description']; ?></td>
	        <td><?= $['date_added']; ?></td>
	        <td>
	            <?php  
	            if ($['is_done'] == 1) {
	                echo '<span style="color: green">Выполнено</span>';
	            } elseif ($['is_done'] == 0) {
	                echo '<span style="color: red">Выполнить</span>';
	            }
	            ?>   
	        </td>
	      
	        <td><strong><?= $['assigned_user_name']; ?></strong></td>
	        <td><strong><?= $['author_name']; ?></strong></td>
	    </tr>
	</table>
	</body>
<footer>
	<p style="padding-top:10px;"><a href="logout.php"> Выйти </a></p>
</footer>
</html>