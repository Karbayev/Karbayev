<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'database.php';

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php?action=auth/login');
    exit();
}

// Получение всех категорий текущего пользователя из базы данных
$stmt = $pdo->prepare("SELECT id, name, color FROM categories WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Создать категорию</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .category-item {
            padding: 10px 15px;
            border-radius: 4px;
            color: #fff; /* Цвет текста */
            margin: 5px; /* Отступ между категориями */
            display: inline-block; /* Отображение в строку */
            white-space: nowrap; /* Предотвращает перенос слов на новую строку */
            font-weight: bold; /* Жирный текст */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Легкая тень */
        }
        .category-list {
            display: flex; /* Используем flexbox для расположения элементов в строку */
            flex-wrap: wrap; /* Позволяет элементам обтекать */
            align-items: center; /* Центрирует элементы по вертикали */
        }
        .form-container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .btn {
            width: 100%; /* Кнопка занимает всю ширину */
        }
        h2, h4 {
            color: #343a40; /* Цвет заголовка */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="/index.php" class="btn btn-primary mt-3">На главную</a>

        <div class="form-container mt-4">
            <h2>Создать категорию</h2>

            <!-- Список существующих категорий -->
            <?php if (!empty($categories)): ?>
                <div class="mb-4">
                    <h4>Существующие категории</h4>
                    <div class="category-list">
                        <?php foreach ($categories as $category): ?>
                            <div class="category-item" style="background-color: <?= htmlspecialchars($category['color']) ?>;">
                                <?= htmlspecialchars($category['name']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <p>Нет созданных категорий.</p>
            <?php endif; ?>

            <!-- Форма для создания новой категории -->
            <form action="/index.php?action=categories/create" method="POST">
                <div class="form-group">
                    <label for="name">Название категории</label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Введите название категории">
                </div>
                <div class="form-group">
                    <label for="color">Цвет</label>
                    <input type="color" class="form-control" id="color" name="color" required>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
