<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Редактировать транзакцию</title>
</head>
<body>
    <div class="container mt-5">
        <a href="/index.php" class="btn btn-primary mt-3">На главную</a>
        <h1>Редактировать транзакцию</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= htmlspecialchars($transaction['id']) ?>">
            <div class="form-group">
                <label for="amount">Сумма</label>
                <input type="number" name="amount" id="amount" class="form-control" value="<?= htmlspecialchars($transaction['amount']) ?>" required>
            </div>
            <div class="form-group">
                <label for="category_id">Категория</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>" <?= $category['id'] == $transaction['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="type">Тип транзакции</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="income" <?= $transaction['type'] == 'income' ? 'selected' : '' ?>>Доход</option>
                    <option value="expense" <?= $transaction['type'] == 'expense' ? 'selected' : '' ?>>Расход</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
</body>
</html>
