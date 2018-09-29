<? 

if (!empty($_FILES)) {
    if(array_key_exists('testfile', $_FILES)){
        if ($_FILES['testfile']['type'] == 'application/json'){
              if (move_uploaded_file($_FILES['testfile']['tmp_name'], 'tests/' . $_FILES['testfile']['name'])){
              echo 'ok';
          }
        }
        else
        {
            $errorText = 'Error, Input Json file';
        }
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Загрузить тест</title>
</head>
<body>

    <form method="POST" enctype=multipart/form-data>
        <p>Загрузите файл .json тест</p>
        <input type=file name=testfile style="margin-bottom: 10px;"></br>
        <input type=submit value=Загрузить>
    </form>
    
    <?=(!empty($errorText)) ? '<h1 style = "color:red;">'.$errorText.'</h1>':''?>
    <ul>
        <li><a href="tests.php">Перейти к тестам</a></li>
        <li><a href="list.php">Список тестов</a></li>
    </ul>
</body>
</html>