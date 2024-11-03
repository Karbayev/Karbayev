<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
</head>
<body>
    <h2>Простой калькулятор</h2>
    <form method="POST" action="">
        <label>Введите первое число:</label>
        <input type="number" name="num1" step="any" required>
        
        <label>Оператор:</label>
        <select name="operator" required>
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        
        <label>Введите второе число:</label>
        <input type="number" name="num2" step="any" required>
        
        <button type="submit" name="calculate">Вычислить</button>
    </form>

    <?php
    if (isset($_POST['calculate'])) {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $operator = $_POST['operator'];
        $result = null;

        switch ($operator) {
            case "+":
                $result = $num1 + $num2;
                break;
            case "-":
                $result = $num1 - $num2;
                break;
            case "*":
                $result = $num1 * $num2;
                break;
            case "/":
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    $result = "Ошибка: деление на ноль";
                }
                break;
            default:
                $result = "Неверный оператор";
                break;
        }

        echo "<h3>Результат: $result</h3>";
    }
    ?>
</body>
</html>
