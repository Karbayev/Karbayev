<!-- App/Views/user-posts.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статьи пользователя</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-4">
        <h1>Статьи пользователя</h1>
    </header>

    <div class="container mt-4">
    <a href="/" class="btn btn-primary">На главную</a>
    <h2>Статьи пользователя <?= htmlspecialchars($username ?? 'Неизвестный пользователь') ?></h2>

        <div class="list-group">
            <?php foreach ($posts as $post): ?>
                <div class="list-group-item">
                    <h5><a href="/view-post/<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h5>
                    <p><?= htmlspecialchars($post['content']) ?></p>
                    <small class="text-muted">Автор: 
                        <a href="/user-posts?user_id=<?= $post['user_id'] ?>">
                            <?= isset($post['author_name']) ? htmlspecialchars($post['author_name']) : 'Неизвестный автор' ?>
                        </a>
                    </small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-4">
        <p>&copy; <?= date('Y') ?> Ваше Имя или Название Компании</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
