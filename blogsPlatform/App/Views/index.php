<!-- Views/index.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Блог платформа</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-4">
        <h1>Блог платформа</h1>
    </header>

    <div class="container mt-4">
        <div class="row">
            <!-- Левая колонка: авторизация и регистрация -->
            <div class="col-md-3">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <h3>Добро пожаловать, <?= htmlspecialchars($_SESSION['username']) ?>!</h3>
                    <a href="/logout" class="btn btn-danger btn-block mb-2">Выход</a>
                <?php else: ?>
                    <h3>Авторизация и Регистрация</h3>
                    <a href="/login" class="btn btn-success btn-block mb-2">Авторизация</a>
                    <a href="/register" class="btn btn-primary btn-block">Регистрация</a>
                <?php endif; ?>
            </div>

            <!-- Средняя колонка: последние статьи -->
            <div class="col-md-6">
                <h3>Последние статьи</h3>
                <ul class="list-group">
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <li class="list-group-item">
                                <a href="/view-post/<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                                <p class="mb-1"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
                                <small class="text-muted">Автор: <a href="/user-posts?user_id=<?= $post['user_id'] ?>"><?= htmlspecialchars($post['author_name']) ?></a></small>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">Нет доступных статей.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Правая колонка: авторы -->
            <div class="col-md-3">
                <h3>Авторы</h3>
                <ul class="list-group">
                    <?php foreach ($authors as $author): ?>
                        <li class="list-group-item">
                        <a href="/user-posts?author_id=<?= $author['id'] ?>"><?= htmlspecialchars($author['username']) ?></a>

                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-4">
        <p>&copy; <?= date('Y') ?> Ваше Имя или Название Компании</p> <!-- Укажите ваше имя или название компании -->
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
