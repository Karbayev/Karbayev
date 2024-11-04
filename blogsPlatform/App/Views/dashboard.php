<!-- Views/dashboard.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель пользователя</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
    <a href="/" class="btn btn-primary">На главную</a>
        <h1 class="mb-4">Добро пожаловать!</h1>
        <a href="/logout" class="btn btn-danger mb-4">Выход</a> <!-- Кнопка выхода -->

        <h2 class="mb-3">Ваши статьи:</h2>
        <ul class="list-group">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <li class="list-group-item">
                        <h3>
                            <a href="/view-post/<?= $post['id'] ?>" class="text-decoration-none"><?= htmlspecialchars($post['title']) ?></a>
                        </h3>
                        <p class="mb-1"><?= htmlspecialchars($post['content']) ?></p>
                        <a href="/view-post/<?= $post['id'] ?>" class="btn btn-primary btn-sm">Просмотреть статью</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    У вас пока нет статей.
                </div>
            <?php endif; ?>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
