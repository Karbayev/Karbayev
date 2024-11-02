<?php

/*реакция на кнопку отправить после введенных данных*/
if (isset($_POST["submit"])) {

    $whatgod = $_POST['visgod']; /*создали переменные на основе введенных данных пользователем*/
    /*переменная для опеределения високосный или нет год*/

    function isleap( $whatgod )
    {
        if( $whatgod % 4 == 0 )
            # Год високосный
            echo 'Год високосный';
        else
            # Год не високосный
            echo 'Год не високосный';
    }
    echo $whatgod;


}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Высокосный ли год</title>
</head>
<body>
<form action="" method="post">
    <p>Введите год в формате 1900: <input type="number" name="visgod" /> <p> <br>

        <input type="submit" name="submit" value="Отправить"><br>

</form>

<?php
/*выводим инициалы имени и отчества, фамилия остается полностью, и добавили точки - разделители*/
echo 'Вывод: '. $whatgod;
?>
</body>
</html>
