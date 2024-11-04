<?php
class TransactionController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function history() {
        $stmt = $this->pdo->query("SELECT * FROM transactions WHERE user_id = " . $_SESSION['user_id']);
        $transactions = $stmt->fetchAll();
        require '../views/transactions/history.php';
    }

    public function create() {
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
                $stmt = $this->pdo->prepare("INSERT INTO categories (user_id, name, color) VALUES (?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $category_name, $category_color]);
                $category_id = $this->pdo->lastInsertId(); // Получаем ID новой категории
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

        // Получаем дату транзакции
        $transaction_date = $_POST['transaction_date'] ?? date('Y-m-d H:i:s'); // Используем текущую дату, если дата не указана

        // Создание транзакции
        $stmt = $this->pdo->prepare("INSERT INTO transactions (user_id, amount, category_id, type, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $amount, $category_id, $type, $transaction_date]);

        // Перенаправление на страницу истории транзакций
        header('Location: /index.php?action=transactions/history');
        exit();
    }
    require '../views/transactions/create.php';
}


    public function chart() {
        // Установка значений по умолчанию
        $month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
        $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

        // Получаем данные для текущего месяца
        $stmt = $this->pdo->prepare("
            SELECT c.name as category_name, SUM(t.amount) as total_amount, c.color as category_color
            FROM transactions t
            JOIN categories c ON t.category_id = c.id
            WHERE t.user_id = ? AND MONTH(t.created_at) = ? AND YEAR(t.created_at) = ?
            GROUP BY c.name, c.color
        ");
        $stmt->execute([$_SESSION['user_id'], $month, $year]);
        $currentMonthData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Получаем данные для предыдущего месяца
        $prevMonth = $month - 1 < 1 ? 12 : $month - 1;
        $prevYear = $prevMonth == 12 ? $year - 1 : $year;

        $stmt->execute([$_SESSION['user_id'], $prevMonth, $prevYear]);
        $prevMonthData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Подготовка данных для графика
        $labels = [];
        $currentData = [];
        $prevData = [];
        $colors = []; // Массив для хранения цветов для категорий

        foreach ($currentMonthData as $result) {
            $labels[] = $result['category_name'];
            $currentData[] = $result['total_amount'];
            $colors[] = $result['category_color'];
        }

        foreach ($prevMonthData as $result) {
            $prevData[$result['category_name']] = $result['total_amount'];
        }

        // Заполняем данные для предыдущего месяца
        foreach ($labels as $label) {
            $prevAmount = isset($prevData[$label]) ? $prevData[$label] : 0;
            $prevData[] = $prevAmount;
        }

        // Передача данных в представление
        require '../views/transactions/chart.php';
    }
}
?>
