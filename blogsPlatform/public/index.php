<?php
session_start();
// Подключаем файл конфигурации путей
require_once '../config/paths.php';

use App\Core\Router;
use App\Controllers\UserController;
use App\Controllers\PostController;
// Подключение HomeController
use App\Controllers\HomeController;

// Подключаем автозагрузчик
require_once '../vendor/autoload.php';

// Инициализация маршрутизатора
$router = new Router();

// Маршруты для работы с пользователем
$router->add('/register', [new UserController(), 'register']);
$router->add('/login', [new UserController(), 'login']);
$router->add('/logout', [new UserController(), 'logout']);

// Маршруты для работы со статьями
$router->add('/create-post', [new PostController(), 'create']);
$router->add('/user-posts', [new PostController(), 'userPosts']);

// Маршруты для кабинета пользователя
$router->add('/dashboard', [new UserController(), 'dashboard']);

// Добавление маршрута для отображения отдельной статьи
$router->add('/view-post/{id}', [new PostController(), 'view']);

// Маршрут для главной страницы
$router->add('/', [new HomeController(), 'index']); // Главная страница

// Обработка текущего URL
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($url);
?>

