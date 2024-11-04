<!-- Views/view_post.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<a href="/" class="btn btn-primary">На главную</a>
    <div class="container mt-5">
        Заголовок:
        <h1 class="mb-4"><?= htmlspecialchars($post['title']) ?></h1>
        
        Основной текст:
        <p class="lead"><?= htmlspecialchars($post['content']) ?></p> <!-- Основной контент статьи -->
        
        <p class="text-muted">Дата создания: <?= date('d.m.Y', strtotime($post['created_at'])) ?></p> <!-- Дата создания статьи -->

        <a href="/user-posts" class="btn btn-secondary mt-3">Назад к вашим статьям</a> <!-- Кнопка для возврата к списку статей -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
