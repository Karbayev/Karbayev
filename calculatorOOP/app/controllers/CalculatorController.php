<?php

require_once '../app/models/CalculatorModel.php';

/**
 * Класс CalculatorController
 * Управляет обработкой запросов к калькулятору, включая валидацию данных, 
 * выполнение расчетов и отображение результата.
 */
class CalculatorController
{
    private $model;

    // Константа с поддерживаемыми операциями
    const OPERATIONS = ['+', '-', '*', '/'];

    /**
     * Конструктор инициализирует модель калькулятора.
     */
    public function __construct()
    {
        $this->model = new CalculatorModel();
    }

    /**
     * Метод index - точка входа контроллера.
     * Принимает и обрабатывает запросы на странице калькулятора.
     * @param string $url Параметр URL, может быть использован для настройки страницы.
     */
    public function index($url)
    {
        // Обработка запроса и получение результата
        $response = $this->handleRequest();
        
        // Включение шаблона, где будут отображаться результат и возможные ошибки
        include '../app/views/calculator.php';
    }

    /**
     * Метод handleRequest - обрабатывает POST-запросы.
     * Валидирует входные данные, вызывает метод модели для расчета и обрабатывает возможные ошибки.
     * @return array Массив с результатом вычисления или сообщением об ошибке.
     */
    private function handleRequest()
    {
        $result = '';  // Инициализация переменной для хранения результата
        $error = '';   // Инициализация переменной для хранения сообщения об ошибке

        // Проверка, что запрос был отправлен методом POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получение и проверка входных данных из формы
            $number1 = $_POST['number1'] ?? null;  // Первое число или null, если не задано
            $number2 = $_POST['number2'] ?? null;  // Второе число или null, если не задано
            $operation = $_POST['operation'] ?? ''; // Операция или пустая строка, если не задана

            // Валидация входных данных
            if ($this->validateInput($number1, $number2, $operation)) {
                try {
                    // Выполнение расчета, если данные корректны
                    $result = $this->model->calculate((float)$number1, (float)$number2, $operation);
                } catch (Exception $e) {
                    // Обработка ошибки, если возникло исключение (например, деление на ноль)
                    $error = 'Ошибка при вычислении: ' . $e->getMessage();
                }
            } else {
                // Сообщение об ошибке, если данные некорректны
                $error = 'Введите корректные значения для чисел и операции.';
            }
        }

        // Возвращаем массив с результатом и ошибкой
        return ['result' => $result, 'error' => $error];
    }

    /**
     * Метод validateInput - проверяет корректность входных данных.
     * @param mixed $number1 Первое число
     * @param mixed $number2 Второе число
     * @param string $operation Операция (например, "+", "-", "*", "/")
     * @return bool Возвращает true, если данные корректны; иначе - false.
     */
    private function validateInput($number1, $number2, $operation)
    {
        // Проверка, что оба числа числовые и операция входит в список поддерживаемых операций
        return is_numeric($number1) && is_numeric($number2) && in_array($operation, self::OPERATIONS);
    }
}

