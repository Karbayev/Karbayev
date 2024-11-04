<?php

namespace App\Core;

class View
{
    // Константа для пути к представлениям
    private const VIEWS_PATH = __DIR__ . '/../Views/';

    /**
     * Отображает указанное представление и передает данные.
     *
     * @param string $view Название представления.
     * @param array $data Массив данных для передачи в представление.
     * @throws \Exception Если файл представления не найден.
     */
    public static function render(string $view, array $data = [])
    {
        extract($data);

        $viewPath = self::VIEWS_PATH . $view . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: {$viewPath}");
        }

        require $viewPath;
    }
}
