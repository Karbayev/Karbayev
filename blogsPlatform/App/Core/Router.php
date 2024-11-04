<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    /**
     * Добавляет маршрут в маршрутизатор.
     *
     * @param string $path Путь маршрута.
     * @param callable $callback Функция или метод для выполнения.
     */
    public function add(string $path, callable $callback)
    {
        $this->routes[$path] = $callback;
    }

    /**
     * Обрабатывает запрос и вызывает соответствующий маршрут.
     *
     * @param string $url URL запроса.
     */
    public function dispatch(string $url)
    {
        foreach ($this->routes as $path => $callback) {
            // Проверяем на совпадение с параметрами
            $pathRegex = preg_replace('/{([^}]+)}/', '([^/]+)', $path);
            if (preg_match('#^' . $pathRegex . '$#', $url, $matches)) {
                array_shift($matches); // Удаляем первый элемент, который является полным совпадением пути
                call_user_func_array($callback, $matches); // Передаем параметры в функцию
                return;
            }
        }

        echo "404 Not Found";
    }
}
