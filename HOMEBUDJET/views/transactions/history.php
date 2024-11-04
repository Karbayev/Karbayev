<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>История транзакций</title>
</head>
<body>
    <div class="container mt-5">
        <a href="/index.php" class="btn btn-primary mt-3">На главную</a>
        <h2>История транзакций</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Сумма</th>
                    <th>Категория</th>
                    <th>Тип</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?= htmlspecialchars($transaction['amount']) ?></td>
                        <td>
                            <?php
                            // Получаем название категории по category_id
                            $stmt = $this->pdo->prepare("SELECT name FROM categories WHERE id = ?");
                            $stmt->execute([$transaction['category_id']]);
                            $category = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo htmlspecialchars($category['name']);
                            ?>
                        </td>
                        <td>
                            <?php if ($transaction['type'] === 'income'): ?>
                                Доход
                            <?php elseif ($transaction['type'] === 'expense'): ?>
                                Расход
                            <?php else: ?>
                                Неизвестно
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($transaction['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/index.php?action=transactions/create" class="btn btn-warning">Добавить транзакцию</a>
    </div>
</body>
</html>
