<?php

/*реакция на кнопку отправить после введенных данных*/
if (isset($_POST["submit"])) {

    $surname = $_POST['surname']; /*создали переменные на основе введенных данных пользователем*/
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    /*var_dump($surname, $firstname, $lastname);*/ /*проверили введенные данные по типу*/
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <p>Фамилия: <input type="text" name="surname" /> <p> <br>
    <p>Имя: <input type="text" name="firstname" /> <p> <br>
    <p>Отчество: <input type="text" name="lastname" /> <p> <br>


        <input type="submit" name="submit" value="Отправить"><br>

</form>

<?php
/*выводим инициалы имени и отчества, фамилия остается полностью, и добавили точки - разделители*/
echo 'Вывод: '. $surname . ' '. mb_substr($firstname, 0, 1). '.'. mb_substr($lastname, 0, 1).'.';
?>
</body>
</html>
