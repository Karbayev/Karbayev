<?php
class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            // Проверьте, существует ли пользователь
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Если пользователь не существует, выдаем ошибку
            if (!$user) {
                $error = "Пользователь не существует.";
                require '../views/auth/login.php'; // Вернуться к форме с ошибкой
                return;
            }
    
            // Проверка пароля
            if (password_verify($password, $user['password'])) {
                // Успешный вход, сохранить сессию
                $_SESSION['user_id'] = $user['id'];
                header('Location: /index.php?action=transactions/history');
                exit();
            } else {
                $error = "Неправильный пароль.";
                require '../views/auth/login.php'; // Вернуться к форме с ошибкой
                return;
            }
        }
    
        require '../views/auth/login.php'; // Показать форму входа
    }
    


    public function logout() {
        // Удаляем все данные сессии
        session_start();
        session_unset(); // Удаляет все переменные сессии
        session_destroy(); // Удаляет сессию

        // Перенаправляем на главную страницу
        header('Location: /index.php');
        exit;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $password]);
            header("Location: /index.php?action=auth/login");
            exit;
        }
        require '../views/auth/register.php';
    }
}
?>
