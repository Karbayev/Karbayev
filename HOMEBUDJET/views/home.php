<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Домашняя бухгалтерия</title>
    <style>
        body {
            /* Добавление анимационного градиента на фон */
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            background-size: 400% 400%; /* Для анимации градиента */
            animation: gradient 15s ease infinite; /* Анимация градиента */
            color: white; /* Цвет текста на фоне */
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .container {
            text-align: center;
            position: relative; /* Чтобы кнопки были на переднем плане */
            z-index: 1; /* Повышаем z-index для контейнера */
        }

        h1, h2 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Тень текста для читаемости */
        }

        .btn {
            margin: 10px; /* Отступ между кнопками */
        }
    </style>
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Домашняя бухгалтерия</h1>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- Отображение кнопок "Войти" и "Регистрация", если пользователь не авторизован -->
            <a href="/index.php?action=auth/login" class="btn btn-primary btn-lg">Войти</a>
            <a href="/index.php?action=auth/register" class="btn btn-success btn-lg">Регистрация</a>
        <?php else: ?>
            <!-- Добро пожаловать и доступ к остальным функциям после авторизации -->
            <h2>Добро пожаловать!</h2>
            <a href="/index.php?action=transactions/history" class="btn btn-info">История</a>
            <a href="/index.php?action=transactions/create" class="btn btn-warning">Добавить транзакцию</a>
            <a href="/index.php?action=categories/create" class="btn btn-success">Создать категорию</a>
            <a href="/index.php?action=transactions/chart" class="btn btn-info">График</a>
            
            <form method="POST" action="/index.php?action=auth/logout" style="display: inline;">
                <button type="submit" class="btn btn-danger">Выйти</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
