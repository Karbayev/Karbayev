<html>
<head>
    <title>Прием данных от пользователя</title>
</head>

<body>
<form action="" method="post">
    <input type="number" name="number1" /><br>
    <input type="number" name="number2" /><br>
    <input type="number" name="number3" /><br>
    <input type="number" name="number4" /><br>

    <input type="submit" name="submit" value="Отправить"><br>

</form>
<?php
if (isset($_POST["submit"])){

    $itogo = $_POST['number1'] + $_POST['number2'] + $_POST['number3'] + $_POST['number4'];


   echo $itogo;
}
?>
</body>
</html>
