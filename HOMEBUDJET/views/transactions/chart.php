<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../models/Transaction.php';
require_once 'database.php';

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php?action=auth/login');
    exit();
}

// Получение всех транзакций текущего пользователя
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$transactionsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Подготовка данных для графика
$categories = [];
$colors = [];

// Группировка транзакций по категориям
foreach ($transactionsData as $transaction) {
    // Получение категории по category_id
    $stmt = $pdo->prepare("SELECT name, color FROM categories WHERE id = ?");
    $stmt->execute([$transaction['category_id']]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $categoryName = $category['name'];
        $categoryColor = $category['color'];

        if (!isset($categories[$categoryName])) {
            $categories[$categoryName] = 0; // Инициализируем сумму для категории
            $colors[$categoryName] = $categoryColor; // Сохраняем цвет категории
        }

        $categories[$categoryName] += $transaction['amount']; // Суммируем транзакции по категориям
    }
}

// Подготовка данных для графика
$labels = array_keys($categories); // Названия категорий
$data = array_values($categories); // Суммы по категориям
$backgroundColors = array_values($colors); // Цвета по категориям

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>График транзакций</title>
</head>
<body>
    <div class="container mt-5">
        <a href="/index.php" class="btn btn-primary mt-3">На главную</a>
        <h2>График транзакций</h2>

        <!-- График транзакций -->
        <canvas id="transactionChart" style="margin-top: 20px;"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('transactionChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar', // Тип графика
                data: {
                    labels: <?= json_encode($labels) ?>, // Названия категорий
                    datasets: [{
                        label: 'Суммы по категориям',
                        data: <?= json_encode($data) ?>, // Суммы по категориям
                        backgroundColor: <?= json_encode($backgroundColors) ?>, // Цвета по категориям
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>
</html>
