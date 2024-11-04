<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Post extends Model
{
    /**
     * Создает новую статью в базе данных.
     *
     * @param int $userId ID пользователя.
     * @param string $title Заголовок статьи.
     * @param string $content Содержание статьи.
     * @return bool Успешность создания статьи.
     */
    public function createPost(int $userId, string $title, string $content): bool
    {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)");
        
        return $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':content' => $content
        ]);
    }

    /**
     * Получает все статьи для конкретного пользователя.
     *
     * @param int $userId ID пользователя.
     * @return array Массив статей.
     */
// Пример запроса в модели Post для получения постов с именем автора
public function getPostsByUser($userId)
{
    $sql = "SELECT p.*, u.username AS author_name FROM posts p
            JOIN users u ON p.user_id = u.id
            WHERE p.user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    /**
     * Получает статью по её ID.
     *
     * @param int $id ID статьи.
     * @return array|null Массив данных статьи или null, если статья не найдена.
     */
    public function getPostById(int $id): ?array
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getLatestPosts($limit = 5): array
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT posts.*, users.username AS author_name FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC LIMIT :limit"
        );
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostsByAuthor(int $authorId)
{
    $stmt = $this->db->prepare("SELECT * FROM posts WHERE author_id = :author_id");
    $stmt->bindParam(':author_id', $authorId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    
    
    public function getAuthors(): array
    {
        $stmt = $this->db->getConnection()->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


}
