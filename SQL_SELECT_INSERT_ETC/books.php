<?php
include "config.php";

// $sql = 'SELECT * FROM books';

// $res = mysqli_query($connect, $sql);

// while ($data[] = mysqli_fetch_assoc($res)){


try {
    $pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $login, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $sqlQuery = "SELECT * FROM `books`";
 	
 	$isbn = (!empty($_GET['isbn'])) ? strip_tags($_GET['isbn']): '';
    $author = (!empty($_GET['author'])) ? strip_tags($_GET['author']): '';
    $name = (!empty($_GET['name'])) ? strip_tags($_GET['name']): '';
    
    if (!$isbn && !$author && !$name) {
        $data = $pdo->prepare($sqlQuery);
        $data->execute();
    } else {
        $sqlQuery = "SELECT * FROM `books` WHERE isbn LIKE '%$isbn%' AND name LIKE '%$name%' AND author LIKE '%$author%' ";
        $data = $pdo->prepare($sqlQuery);
        $data->execute([$isbn, $author, $name]);
    }
} catch (PDOException $e) {
    die($e->getMessage());
}


// $id = (int($_GET[id]))  защита числа 
// $name = strip_tags($_GET[NAME]); защита строки или htmlspecialchars

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SQL</title>
</head>
<body>
	<h1>Библиотека успешного человека</h1>
	<div style="margin-bottom: 5px;">
        <form method="GET">
            <input type="text" name="isbn" placeholder="ISBN" id="ISBN" value="<?=$isbn?>">
            <input type="text" name="author" placeholder="Автор книги" id="author" value="<?=$author?>">
            <input type="text" name="name" placeholder="Название книги" id="bookname" value="<?=$name?>">
            <input type="submit" value="Поиск">
        </form>
    </div>
	<table style="border-spacing: 0">
		<tr>
	    	<td style="border: 1px solid #ccc;text-align: center;background: #eee;">Название</td>
	        <td style="border: 1px solid #ccc;text-align: center;background: #eee;">Автор</td>
	        <td style="border: 1px solid #ccc;text-align: center;background: #eee;">Год</td>
	        <td style="border: 1px solid #ccc;text-align: center;background: #eee;">Жанр</td>
	        <td style="border: 1px solid #ccc;text-align: center;background: #eee;">ISBN</td>
	    </tr>
		
		<?php foreach ($data as $row): ?>
	        <tr style="border: 1px solid #ccc;">
     			<td style="border: 1px solid #ccc;"><?php echo ($row['name']) ?></td>
                <td style="border: 1px solid #ccc;"><?php echo ($row['author']) ?></td>
                <td style="border: 1px solid #ccc;"><?php echo ($row['year']) ?></td>
                <td style="border: 1px solid #ccc;"><?php echo ($row['genre']) ?></td>
                <td style="border: 1px solid #ccc;"><?php echo ($row['isbn']) ?></td>
	        </tr>
	    <?php endforeach; ?>
	</table>
</body>
</html>