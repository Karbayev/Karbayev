<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../models/Transaction.php';
require_once __DIR__ . '/../../models/Category.php';
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

// Обработка формы при отправке
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $type = $_POST['type']; // income or expense

    // Проверяем, если выбрана существующая категория
    if (!empty($_POST['existing_category'])) {
        $category_id = $_POST['existing_category'];
    } else {
        // Если категория не выбрана, создаем новую
        $category_name = $_POST['category_name'] ?? ''; // Задаем значение по умолчанию
        $category_color = $_POST['category_color'] ?? '#000000'; // Значение по умолчанию для цвета

        if (!empty($category_name)) {
            // Проверяем, что имя категории не пустое
            $stmt = $pdo->prepare("INSERT INTO categories (user_id, name, color) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $category_name, $category_color]);
            $category_id = $pdo->lastInsertId(); // Получаем ID новой категории
        } else {
            // Если имя категории пустое, перенаправляем с сообщением об ошибке
            header('Location: /index.php?action=transactions/create&error=Введите название категории');
            exit();
        }
    }

    // Проверка, что category_id не пустой
    if (empty($category_id)) {
        header('Location: /index.php?action=transactions/create&error=Не удалось получить ID категории');
        exit();
    }

    // Создание транзакции
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, amount, category_id, type, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $amount, $category_id, $type, date('Y-m-d H:i:s')]);

    // Перенаправление на страницу истории транзакций
    header('Location: /index.php?action=transactions/history');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Добавить транзакцию</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid #000;
            vertical-align: middle;
            margin-left: 5px; /* Расстояние между текстом и цветом */
        }
        .small-label {
            font-size: 0.875rem; /* Уменьшенный размер шрифта для названия категории */
        }
        .amount-input {
            width: 100px; /* Уменьшаем ширину поля для суммы */
        }
        .category-container {
            display: flex;
            align-items: center; /* Выравнивание по центру по вертикали */
            margin-bottom: 15px; /* Отступ между элементами */
        }
        .category-name-input {
            width: 150px; /* Уменьшаем ширину поля для названия категории */
            margin-right: 10px; /* Расстояние между полем и выбором цвета */
        }
        .form-check-label {
            margin-left: 5px; /* Отступ между радиокнопкой и текстом */
        }
        h1 {
            color: #343a40;
        }
    </style>
</head>
<body>
    
    <div class="container mt-5">
        <a href="/index.php" class="btn btn-primary mt-3">На главную</a>
        <div class="form-container">
            <h1>Добавить транзакцию</h1>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="amount">Сумма</label>
                    <input type="number" name="amount" id="amount" class="form-control amount-input" required>
                </div>

                <!-- Новый блок для выбора существующей категории -->
                <div class="form-group">
                    <label>Выберите существующую категорию</label>
                    <?php foreach ($categories as $category): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="existing_category" id="category_<?= $category['id'] ?>" value="<?= $category['id'] ?>">
                            <label class="form-check-label" for="category_<?= $category['id'] ?>">
                                <?= htmlspecialchars($category['name']) ?>
                                <span class="color-preview" style="background-color: <?= htmlspecialchars($category['color']) ?>;"></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Кнопка сброса выбранной категории -->
                <button type="button" class="btn btn-secondary mb-3" onclick="resetCategory()">Сбросить выбранную категорию</button>

                <!-- Поля для создания новой категории -->
                <div class="form-group category-container">
                    <label class="small-label" for="category_name">Название новой категории</label>
                    <input type="text" name="category_name" id="category_name" class="form-control category-name-input" placeholder="Если не выбрана категория">
                    <label class="small-label mr-2" for="category_color">Цвет</label>
                    <input type="color" name="category_color" id="category_color" class="form-control" required style="width: 50px; height: 50px;">
                </div>

                <div class="form-group">
                    <label for="type">Тип транзакции</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="income" value="income" required>
                        <label class="form-check-label" for="income">Доход</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="expense" value="expense">
                        <label class="form-check-label" for="expense">Расход</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Добавить транзакцию</button>
            </form>
        </div>
    </div>

    <script>
        function resetCategory() {
            // Сбросить выбранную категорию
            const radios = document.getElementsByName('existing_category');
            radios.forEach(radio => {
                radio.checked = false; // Снимаем выбор со всех радиокнопок
            });
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
