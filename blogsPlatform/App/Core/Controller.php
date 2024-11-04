<?php

namespace App\Core;

class Controller
{
    /**
     * Загружает представление и передает данные.
     *
     * @param string $view Название представления.
     * @param array $data Массив данных для передачи в представление.
     */
    public function render(string $view, array $data = [])
    {
        extract($data);
        // Используем константу для пути к представлениям
        require VIEWS_PATH . $view . '.php';
    }
}
