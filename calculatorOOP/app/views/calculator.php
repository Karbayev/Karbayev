<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор</title>
</head>
<body>

    <div class="calculator-container">
        <!-- Экран для отображения результата -->
        <div class="display">
            <?= htmlspecialchars($response['result']) ?: "0" ?>
        </div>

        <form method="post" action="" class="calculator-form">
            <!-- Поля для ввода чисел и выбора операции -->
            <input type="text" name="number1" class="calculator-input" placeholder="Введите число 1" required>
            <select name="operation" class="calculator-input">
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
            </select>
            <input type="text" name="number2" class="calculator-input" placeholder="Введите число 2" required>

            <!-- Кнопки с числами -->
            <button type="button" class="calculator-button number-button">7</button>
            <button type="button" class="calculator-button number-button">8</button>
            <button type="button" class="calculator-button number-button">9</button>
            <button type="button" class="calculator-button operation-button">/</button>

            <button type="button" class="calculator-button number-button">4</button>
            <button type="button" class="calculator-button number-button">5</button>
            <button type="button" class="calculator-button number-button">6</button>
            <button type="button" class="calculator-button operation-button">*</button>

            <button type="button" class="calculator-button number-button">1</button>
            <button type="button" class="calculator-button number-button">2</button>
            <button type="button" class="calculator-button number-button">3</button>
            <button type="button" class="calculator-button operation-button">-</button>

            <button type="button" class="calculator-button number-button">0</button>
            <button type="button" class="calculator-button number-button">.</button>
            <button type="submit" class="calculator-button equal-button">=</button>
            <button type="button" class="calculator-button operation-button">+</button>

            <!-- Поле для отображения ошибки -->
            <p class="error"><?= htmlspecialchars($response['error']) ?></p>
        </form>
    </div>

</body>
</html>

