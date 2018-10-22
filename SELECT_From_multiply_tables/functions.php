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
		$data = $data->fetchAll();
		return $data;
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