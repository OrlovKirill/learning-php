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