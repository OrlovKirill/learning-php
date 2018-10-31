<?

function getData($pdo, $select, $from, $condition= array()){
	if (is_array($select))
	{
		$select = implode(",", $select);
	}
	if (is_array($condition))
	{
		$condition = implode(" AND ", $condition);
	}
	$sql = "SELECT ". $select. " FROM ".$from;
	if (!empty ($condition)){
		$sql .= " WHERE ". $condition;
	}
	$data = $pdo->prepare($sql);
	$data->execute();
	// $data = $data->fetchAll();
	return $data;
}

// function sortBy($pdo, $select, $from , $addTable,$addField ,$condition, $order){
// 	if (is_array($select))
// 	{
// 		$select = implode(",", $select);
// 	}
// 	$sql = "SELECT ".$select." FROM ".$from." LEFT JOIN ".$addTable." ON ".$addField." WHERE ".$condition." ORDER BY ".$order;
// 	$data = $pdo->prepare($sql);
// 	$data->execute();
// 	return $data;
// }


// // $sqlQuery = sortBy($pdo,array('*', 'user.login'), 'task', 'user', 'user.id=task.user_id', 'user.id='.$_SESSION['id'], 'description');

function getPdo($login, $pass, $server, $db){		
	try{
		$pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $login, $pass, [
	        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	    ]);	
	}	catch (PDOException $e) {
	    	die($e->getMessage());
	}
	return $pdo;
}

function myDebug($condition){
	echo("<pre>");
	print_r($condition);
	echo("</pre>");
	die();
}
	// function registr($pdo, $insert, $values){
	// 	if (is_array($values)){
	// 		$values = implode(",", $values);
	// 	}
	// 	$sql="INSERT INTO ".$insert." VALUES ".$values."\"";
	// 	// $sql="INSERT INTO `user` (login, password) VALUES ('".addslashes($_POST['login'])."', '".md5(addslashes($_POST['password']))."')";
	// 	$data = $pdo->prepare($sql);
	// 	$data->execute();
	// 	return $data;
	// }
?>