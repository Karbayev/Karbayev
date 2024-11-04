<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    /**
     * Создает нового пользователя в базе данных.
     *
     * @param string $username Имя пользователя.
     * @param string $password Пароль.
     * @param string $email Электронная почта.
     * @return bool Успешность создания пользователя.
     */
    public function createUser(string $username, string $password, string $email): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->getConnection()->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
        
        return $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
            ':email' => $email
        ]);
    }

    /**
     * Получает пользователя по имени пользователя.
     *
     * @param string $username Имя пользователя.
     * @return array|null Данные пользователя или null.
     */
    public function getUserByUsername(string $username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Получает пользователя по его ID.
     *
     * @param int $id ID пользователя.
     * @return array|null Данные пользователя или null, если пользователь не найден.
     */
    public function getUserById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, username FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
