<?php
require 'MyApp/Controllers/UserController.php';//Здесь мы подключаем файлы
require 'AnotherApp/Controllers/UserController.php';

$controller1 = new \MyApp\Controllers\UserController(); //Создаем экземпляр класса
$controller1->show();  // Выведет: User Controller from MyApp

$controller2 = new \AnotherApp\Controllers\UserController();
$controller2->show();  // Выведет: User Controller from AnotherApp