<?
$data = file_get_contents("data.json");
$decode_data = json_decode($data, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ДЗ "HTML + JSON"</title>
</head>
<body>
	<div>
		<table>
			<thead>
				<tr>
					<th>Имя</th>
					<th>Фамилия</th>
					<th>Адрес</th>
					<th>Телефон</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($decode_data as $phonebook):?>
				<tr>
					<td><?=$phonebook['firstName'];?></td>
					<td><?=$phonebook['lastName'];?></td>
					<td><?=$phonebook['address'];?></td>
					<td><?=$phonebook['phoneNumber'];?></td>
				</tr>	
			<?php endforeach;?>	
			</tbody>
		</table>
	</div>
</body>
</html>