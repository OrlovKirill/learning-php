<?php
session_start();
$name = $_POST['name'];
$password = $_POST['password'];

$file_test = file_get_contents(__DIR__.'/users/users.json');
$decode_file = json_decode($file_test, true);

foreach ($decode_file as $item){
	$userName[$item['name']] = $item['password']; 
}

if (isset($_POST['captcha']) && ($_POST['captcha'] != $_SESSION['checker'])){
	$_SESSION['count']++;
	if ($_SESSION['count']>=11){
		setcookie('access', 'block', time()+3600);	
		session_destroy();
	}
}

else{
	if(!empty($_POST['name'])) {
		if (isset($userName[$_POST['name']]) && ($userName[$_POST['name']] === $_POST['password'])) {
			$_SESSION['user'] = $_POST['name'];	
			$_SESSION['login'] = true;
			unset($_SESSION['guest']);
			header('Location: list.php');
			die;
		}
		elseif (isset($_POST['name']) && strlen($_POST['password']) <= 0) {
			$_SESSION['guest'] = $_POST['name'];
			$_SESSION['login'] = true;
			unset($_SESSION['user']);
			header('Location: list.php');
			die;
		}
		else {
			$_SESSION['count']++;
		}
	}
	elseif (empty($_POST['name']) && empty($_POST['password']) && ($_SESSION['count']>1)){
		$response = 'Вы ничего не ввели.';	
		$_SESSION['count']=$_SESSION['count'];
	}
	elseif (empty($_POST['name']) && !empty($_POST['password'])){
		$response = 'Вы не ввели логин';
	}
	else{
		$response = '';
	}
}

if ($_SESSION['count']>5){
	$showCaptcha = true;
}

if(!empty($_COOKIE['access'])){
	http_response_code(403);
	exit("Слишком много ошибок, мы вас заблокировали на час");
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
</head>
<body>
	<h1>Авторизация</h1>
	<form method="POST">
		<h2>Введите Ваше имя и пароль</h2>
		<p><input type="text" name="name" placeholder="Имя" autocomplete="off"></p>
    	<p><input type="password" name="password" placeholder="Пароль" autocomplete="off"></p>
    	<p><button type="submit">Войти</button>
    		<?php if ($response){
    			echo ($response);
    		}
    		if ($_SESSION['count']>=1 && !isset($response)){
    			echo 'Неверный логин или пароль';
    		}
    		?>

    	<h3>Если вы хотите зайти, как гость введите только ваше имя</h3>
  
    	 <?php if ($showCaptcha): ?>
            <div style="margin-bottom:10px;>
                <label ">
                    Введите код с картинки:
                    <input name="captcha" type="text">
                </label>
            </div>
            
            <div>
                <img src="image.php" style = "width:450px; height:150px;">
            </div>
        <?php endif; ?>
	</form>
	
</body>
</html>