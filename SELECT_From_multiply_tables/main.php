<?
include "config.php";
include "functions.php";
//Массив сортировки по значению
$arMapping = [
	'dateCreated' => 'date_added',
	'isDone' => 'is_done',
	'taskDescription' => 'description'
];
//массив сортировки по типу
$arSortType = [
	'asc' => 'asc',
	'desc' => 'desc'
];


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

// ДОБАВЛЕНИЕ ДЕЛА
	if(!empty($_POST['add'])){
	$description = $_POST['description'];
	$sql = "INSERT INTO task (user_id, assigned_user_id, description, is_done, date_added) VALUES (?, ?, ?, ?, now())";
	$add = $pdo->prepare($sql);
	$add->execute([$_SESSION['id'], $_SESSION['id'], $description, false]);
	header('Location: main.php');
}

//Сортировка
if (!empty($_POST['sort'])){
	// if ($_POST['sortBy'] == 'dateCreated'){
		// $sqlQuery = sortBy($pdo,array('*', 'user.login'), 'task', 'user', 'user.id=task.user_id', 'user.id='.$_SESSION['id'], 'description');
		$sqlQuery = "SELECT description, date_added, is_done, assigned_user_id, user_id, user.login, u2.login as assigned_login FROM task LEFT JOIN user ON user.id=task.user_id LEFT JOIN user as u2 ON u2.id=task.assigned_user_id WHERE user_id =".$_SESSION['id'];
		if (isset($arMapping[$_POST['sortBy']])){
			$sqlQuery.=" ORDER BY ".$arMapping[$_POST['sortBy']];
			if(isset($arSortType[$_POST['sortType']])){
				$sqlQuery.= " ".$arSortType[$_POST['sortType']];
			}
		}

		$data = $pdo->prepare($sqlQuery);
		$data->execute();
}
//При первом входе выборка всего
else{
	$sql = "SELECT description, date_added, is_done, assigned_user_id, user_id, user.login, u2.login as assigned_login FROM task LEFT JOIN user ON user.id=task.user_id LEFT JOIN user as u2 ON u2.id=task.assigned_user_id WHERE user_id =".$_SESSION['id'];
	$data = $pdo->prepare($sql);
		$data->execute();
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
			<label for="sortBy">Сортировать по:</label>
				<select name="sortBy" id="sortBy">
					<option <?=($_POST['sortBy']=='dateCreated') ? 'selected="selected"' : '' ?> value="dateCreated">дате добавления</option>
					<option <?=($_POST['sortBy']=='isDone') ? 'selected="selected"' : '' ?>  value="isDone">статусу</option>
					<option <?=($_POST['sortBy']=='taskDescription') ? 'selected="selected"' : '' ?> value="taskDescription">описанию</option>
				</select>
				<select name="sortType">
					<option <?=($_POST['sortType']=='desc') ? 'selected="selected"' : '' ?> value="desc">по возрастанию</option>
					<option <?=($_POST['sortType']=='asc') ? 'selected="selected"' : '' ?>value="asc">по убыванию</option>
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

			<?foreach ($data as $row): ?>	
			<tr>
				<td><?= $row['description']; ?></td>
		        <td><?= $row['date_added']; ?></td>
		        <td>
		            <?php  
		            if ($row['is_done'] == 1) {
		                echo '<span style="color: green">Выполнено</span>';
		            } elseif ($row['is_done'] == 0) {
		                echo '<span style="color: red">Не Выполнено</span>';
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