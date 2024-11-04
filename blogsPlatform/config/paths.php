<?php
// config/paths.php

// Определяем корень проекта
define('ROOT_PATH', __DIR__ . '/../');

// Определяем путь к папке public
define('PUBLIC_PATH', ROOT_PATH . 'public/');

// Определяем путь к папке app
define('APP_PATH', ROOT_PATH . 'app/');

// Определяем путь к папке Controllers
define('CONTROLLERS_PATH', APP_PATH . 'Controllers/');

// Определяем путь к папке Models
define('MODELS_PATH', APP_PATH . 'Models/');

// Определяем путь к папке Views
define('VIEWS_PATH', APP_PATH . 'Views/');

// Определяем путь к папке Core
define('CORE_PATH', APP_PATH . 'Core/');

// Определяем путь к папке с конфигурациями
define('CONFIG_PATH', ROOT_PATH . 'config/');

// Определяем путь к папке с SQL скриптами
define('SQL_PATH', ROOT_PATH . 'sql/');
