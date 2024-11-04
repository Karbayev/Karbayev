<?php

namespace App\Controllers;

use App\Models\Post;
use App\Core\View;

class HomeController
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function index()
    {
        // Получаем последние статьи и авторов
        $posts = $this->postModel->getLatestPosts(5);
        $authors = $this->postModel->getAuthors();

        // Отображаем главную страницу с переданными данными
        View::render('index', ['posts' => $posts, 'authors' => $authors]);
    }
}
