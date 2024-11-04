<?php
session_start();

// Подключите ваши контроллеры
require_once '../database.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/TransactionController.php';
require_once '../controllers/CategoryController.php';

// Получите действие из URL
$action = $_GET['action'] ?? 'home'; // Действие по умолчанию

// Создание экземпляра контроллера и вызов метода
switch ($action) {
    case 'auth/login':
        $controller = new AuthController($pdo);
        $controller->login();
        break;
    case 'auth/register':
        $controller = new AuthController($pdo);
        $controller->register();
        break;
    case 'auth/logout': // Добавлено действие для выхода
        $controller = new AuthController($pdo);
        $controller->logout(); // Вызов метода logout
        break;
    case 'transactions/history':
        $controller = new TransactionController($pdo);
        $controller->history();
        break;
    case 'transactions/create':
        $controller = new TransactionController($pdo);
        $controller->create();
        break;
    case 'categories/create':
        $controller = new CategoryController($pdo);
        $controller->create();
        break;
    case 'transactions/chart':
        $controller = new TransactionController($pdo);
        $controller->chart();
        break;
    default:
        // Отображение главной страницы или ошибки 404
        require '../views/home.php';
        break;
}
?>
