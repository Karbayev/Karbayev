<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\User; // Импортируем модель User для работы с пользователями
use App\Core\View;

class PostController extends Controller
{
    private Post $postModel;
    private User $userModel; // Добавляем свойство для работы с пользователями

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User(); // Инициализация модели пользователей
    }

    /**
     * Отображает форму добавления новой статьи и обрабатывает добавление.
     */
    public function create()
    {
        // Проверяем, авторизован ли пользователь
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login'); // Перенаправление на страницу входа, если пользователь не авторизован
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            if ($this->postModel->createPost($userId, $title, $content)) {
                echo "Статья успешно добавлена!";
                // Можно добавить перенаправление на другую страницу, например, на панель пользователя
                header('Location: /dashboard'); 
                exit;
            } else {
                echo "Ошибка добавления статьи.";
            }
        } else {
            // Отображаем форму для создания статьи
            View::render('create_post');
        }
    }

    /**
     * Отображает список статей пользователя.
     */
    public function userPosts()
    {
        // Проверяем, авторизован ли пользователь
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login'); // Перенаправление на страницу входа, если пользователь не авторизован
            exit;
        }
    
        $userId = $_SESSION['user_id'];
        $posts = $this->postModel->getPostsByUser($userId);
        
        // Получаем данные о пользователе
        $user = $this->userModel->getUserById($userId);
        $username = $user['username'] ?? 'Неизвестный пользователь'; // Инициализация имени пользователя

        // Передаем статьи и имя пользователя в представление
        View::render('user_posts', ['posts' => $posts, 'username' => $username]);
    }

    /**
     * Отображает отдельную статью.
     */
    public function view($id)
    {
        $post = $this->postModel->getPostById($id); // Получаем статью по ID
        if ($post) {
            View::render('view_post', ['post' => $post]); // Отображаем представление статьи
        } else {
            echo "Статья не найдена.";
        }
    }
}
