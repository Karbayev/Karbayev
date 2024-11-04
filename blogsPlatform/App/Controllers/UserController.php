<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Post; // Добавлено для работы с постами
use App\Core\View;

class UserController extends Controller
{
    private User $userModel;
    private Post $postModel; // Добавлено свойство для работы с постами

    public function __construct()
    {
        $this->userModel = new User();
        $this->postModel = new Post(); // Инициализация модели постов
    }

    /**
     * Отображает форму регистрации и обрабатывает регистрацию.
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Ваша логика проверки на пустые поля и другие проверки
            if ($this->userModel->createUser($username, $password, $email)) {
                echo "Регистрация успешна!";
                // Здесь можно перенаправить пользователя на страницу входа
            } else {
                echo "Ошибка регистрации.";
            }
        } else {
            View::render('register'); // Отображаем форму регистрации
        }
    }

    /**
     * Обрабатывает авторизацию пользователя.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->userModel->getUserByUsername($username);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username']; // Сохраняем имя пользователя в сессии
                header('Location: /dashboard'); // Перенаправляем на панель пользователя
                exit;
            } else {
                // Выводим сообщение об ошибке
                $errorMessage = "Неверное имя пользователя или пароль.";
                View::render('login', ['error' => $errorMessage]); // Передаем сообщение в представление
            }
        } else {
            View::render('login');
        }
    }

    /**
     * Отображает панель пользователя и его статьи.
     */
    public function dashboard()
    {
        // Проверяем, есть ли пользователь в сессии
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login'); // Перенаправляем на страницу входа, если не авторизован
            exit;
        }

        $userId = $_SESSION['user_id'];
        $posts = $this->postModel->getPostsByUser($userId); // Получаем статьи пользователя
        View::render('dashboard', ['posts' => $posts]); // Отображаем представление с данными
    }

    /**
     * Обрабатывает выход пользователя.
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']); // Удаляем имя пользователя из сессии
        session_destroy();
        header('Location: /login'); // Перенаправляем на страницу входа
        exit;
    }
}
