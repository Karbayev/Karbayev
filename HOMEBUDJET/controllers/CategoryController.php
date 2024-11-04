<?php
class CategoryController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $color = $_POST['color'];
            $stmt = $this->pdo->prepare("INSERT INTO categories (user_id, name, color) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $name, $color]);
            header("Location: /index.php?action=transactions/history");
            exit;
        }
        require '../views/categories/create.php';
    }
}
?>
