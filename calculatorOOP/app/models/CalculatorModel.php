<?php

/**
 * Класс CalculatorModel
 * Выполняет арифметические операции для калькулятора.
 */
class CalculatorModel
{
    /**
     * Метод calculate - выполняет арифметическую операцию над двумя числами.
     * @param float $number1 Первое число
     * @param float $number2 Второе число
     * @param string $operation Операция для выполнения ('+', '-', '*', '/')
     * @return float|int Результат арифметической операции
     * @throws Exception Если операция некорректна или попытка деления на ноль
     */
    public function calculate($number1, $number2, $operation)
    {
        switch ($operation) {
            case '+':
                return $number1 + $number2; // Сложение
            case '-':
                return $number1 - $number2; // Вычитание
            case '*':
                return $number1 * $number2; // Умножение
            case '/':
                if ($number2 == 0) {
                    // Исключение при попытке деления на ноль
                    throw new Exception('Деление на ноль невозможно.');
                }
                return $number1 / $number2; // Деление
            default:
                // Исключение для недопустимой операции
                throw new Exception('Недопустимая операция.');
        }
    }
}

