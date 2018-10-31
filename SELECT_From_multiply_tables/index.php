<?
include "config.php";
include "functions.php";
session_start();
$pdo = getPdo($login, $pass, $server, $db);

	// $sql = "SELECT * FROM user";
	// $data = $pdo->prepare($sql);
	// $data->execute();
	// foreach ($data as $key) {
	// 	print_r ($key);
	// }

//v otdelnuu

	// echo '<pre>';
	// $data = getData($pdo,'*','user');
	// foreach ($data as $key) {
	// 		print_r ($key);
	// 	}


	if (!empty($_POST['enter'])){		
		$data = getData($pdo,array('login', 'password'),'user', array('login =\''.addslashes($_POST['login']).'\'', 'password =\''.md5(addslashes($_POST['password'])).'\''));
		$data = $data->fetch(PDO::FETCH_ASSOC);
		

		if(!empty($data)){	
			$id = getData($pdo, 'id','user','login =\''.addslashes($_POST['login']).'\'');
			$result = $id->fetch(PDO::FETCH_ASSOC);
			$_SESSION['user'] = $_POST['login'];
			$_SESSION['id'] = $result['id'];
			header('Location: main.php');//sessiya proidena 
			//добавить вывод пароля из sql и его проверку с введенным
		}
		else{
			echo 'Такого логина или пароля не существует';
		}
	}




	if(!empty($_POST['register'])){
		$data = getData($pdo,array('login', 'password'),'user', 'login =\''.addslashes($_POST['login']).'\'');
		$data = $data->fetchAll();
		if(!empty($data)){
			echo 'такой логин уже существует';
		}
		elseif(!empty($_POST['password'])){
			// $data = registr($pdo,'user (login, password)', array('\''.addslashes($_POST['login']).'\'', '\''.md5(addslashes($_POST['password'])).'\''));
			$sql="INSERT INTO `user` (login, password) VALUES ('".addslashes($_POST['login'])."', '".md5(addslashes($_POST['password']))."')";
			$data = $pdo->prepare($sql);
			// $sql = $sql->fetchAll();
			$data->execute();
			echo 'Вы зарегистрировались с именем '.$_POST['login'].'. Теперь вы можете войти под вашим логином';
				// if(!empty($data)){
				// echo 'Вы зарегистрировались с именем '.$_POST['login'].'. Теперь вы можете войти под вашим логином';
				// }
		}
		else{
			echo 'Вы забыли ввести пароль';
		}	
		// foreach ($data as $key) {
		// 	$keys[] = $key['login'];
		// 	print_r($keys);
		// 	}
		// if ($_POST['login'] != $keys['0']){
		// 	echo'lox';
		// }
		// else {
		// 	echo 'a';
		// }
		
	
		
	}
	// $data = getData($pdo,array('login', 'password'),'user', array('login =\''.$_POST['login'].'\'', 'password =\''.$_POST['password'].'\''));
	// print_r($_POST['enter']);
	// foreach ($data as $key) {
	// 		print_r ($key);
	// 	}
	// echo '</pre>';


	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SELECT</title>
</head>
<body>
	<h1>Введите данные для регистрации или войдите, если уже зарегистрированы</h1>

	<form method="POST">
		<input type="text" name="login" placeholder="login" id="login" value="<?=$_POST['login']?>">
		<input type="text" name="password" placeholder="password" id="password" value="<?=$_POST['password']?>">
		<input type="submit" name="enter" value="Войти">
		<input type="submit" name="register" value="Зарегистрироваться">
	</form>
	
</body>
</html>