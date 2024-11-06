<?php

// Подключение к базе данных через PDO, здесь будут открытые данные логин и пароля а так можно и через подключение файла и файле создать массив и его подставлять сюда, чтобы не было открытых данных. Но для тестового сделал открытым.
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');

/**
 * Функция создания заказа
 * @param int $event_id - уникальный ид события. У каждого события есть свое название, описание, расписание, цены и свой уникальный event_id соответственно
 * @param string $event_date - дата и время на которое были куплены билеты
 * @param array $ticket_details - Массив с информацией о билетах (создал ключи: 'adult', 'kid', 'discount', 'group')
 */
function createOrder($event_id, $event_date, $ticket_details) {
    global $pdo;

    // Цикл do-while здесь нужен, чтобы гарантировать, что каждый заказ получит уникальный штрих-код
    do {
        $barcode = generateBarcode();
        $bookingResult = bookOrder($event_id, $event_date, $ticket_details, $barcode);
    } while ($bookingResult === 'barcode already exists');

    // Подтверждение заказа
    $approveResult = approveOrder($barcode);
    if ($approveResult === 'order successfully approved') {
        // Сохранение заказа в БД - если все ок
        saveOrderToDatabase($event_id, $event_date, $ticket_details, $barcode);
    } else { //Иначе ошибка
        throw new Exception("Ошибка при подтверждении: " . $approveResult);
    }
}

/**
 * Генерация уникального штрих-кода для заказа
 * @return string
 */
function generateBarcode() {
    return str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT); //думаю диапазона хватит
}

/**
 * Бронирование заказа через стороннее API
 * @param int $event_id - уникальный ид события. У каждого события есть свое название, описание, расписание, цены и свой уникальный event_id соответственно
 * @param string $event_date - дата и время на которое были куплены билеты
 * @param array $ticket_details - Массив с информацией о билетах
 * @param string $barcode - Штрих-код заказа
 * @return string - Результат бронирования
 */
//функция bookOrder возвращает текстовое сообщение о результате бронирования — либо подтверждение, что заказ забронирован, либо ошибку, например, "barcode already exists"
function bookOrder($event_id, $event_date, $ticket_details, $barcode) { //создаю функцию
    $data = array_merge($ticket_details, [
        'event_id' => $event_id,
        'event_date' => $event_date,
        'barcode' => $barcode
    ]);
    $response = mockApiRequest('https://api.site.com/book', $data);
    return $response['message'] ?? $response['error'];
}

/**
 * Подтверждение заказа через API
 * @param string $barcode - Штрих-код заказа
 * @return string - Результат подтверждения
 */
function approveOrder($barcode) {
    $response = mockApiRequest('https://api.site.com/approve', ['barcode' => $barcode]);
    return $response['message'] ?? $response['error'];
}

/**
 * Сохранение заказа в базу данных
 * @param int $event_id - уникальный ид события. У каждого события есть свое название, описание, расписание, цены и свой уникальный event_id соответственно
 * @param string $event_date - дата и время на которое были куплены билеты
 * @param array $ticket_details - Информация о билетах (взрослые, детские, льготные, групповые)
 * @param string $barcode - Штрих-код заказа
 */
function saveOrderToDatabase($event_id, $event_date, $ticket_details, $barcode) {
    global $pdo;

    $equal_price = 0;
    foreach ($ticket_details as $ticket_type => $ticket) {
        $equal_price += $ticket['price'] * $ticket['quantity'];
    }

    // Сохранение основного заказа использовал PDO::prepare — который подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
    $stmt = $pdo->prepare("INSERT INTO orders (event_id, event_date, barcode, equal_price, created) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$event_id, $event_date, $barcode, $equal_price]);
    $order_id = $pdo->lastInsertId();

    // Сохранение билетов с уникальными штрих-кодами
    foreach ($ticket_details as $ticket_type => $ticket) {
        $ticket_type_id = getTicketTypeId($ticket_type);

        for ($i = 0; $i < $ticket['quantity']; $i++) {
            $individual_barcode = generateBarcode();
            $stmt = $pdo->prepare("INSERT INTO order_tickets (order_id, ticket_type_id, ticket_price, barcode) VALUES (?, ?, ?, ?)");
            //PDO::execute — Выполняет подготовленный запрос
            $stmt->execute([$order_id, $ticket_type_id, $ticket['price'], $individual_barcode]);
        }
    }
}

/**
 * Получение ID типа билета по его названию
 * @param string $ticket_type - Название типа билета
 * @return int - ID типа билета
 */
function getTicketTypeId($ticket_type) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM ticket_types WHERE type_name = ?");
    $stmt->execute([$ticket_type]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['id'];
}

/**
 * Мокаем запросы к API
 * @param string $url - URL API
 * @param array $data - Данные запроса
 * @return array - Ответ API
 */
function mockApiRequest($url, $data) {
    $responses = [
        ['message' => 'order successfully booked'],
        ['error' => 'barcode already exists'],
        ['message' => 'order successfully approved'],
        ['error' => 'event cancelled'],
        ['error' => 'no tickets'],
        ['error' => 'no seats'],
        ['error' => 'fan removed']
    ];
    return $responses[array_rand($responses)];
}
/*SQL-запросы для нормализации таблиц
Таблица заказов
CREATE TABLE orders ( // 
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    event_date DATETIME NOT NULL,
    barcode VARCHAR(120) UNIQUE,
    equal_price INT NOT NULL,
    created DATETIME DEFAULT CURRENT_TIMESTAMP
);

Таблица типов билетов
CREATE TABLE ticket_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(50) UNIQUE NOT NULL,
    base_price INT NOT NULL
);

Таблица с билетами, связанная с заказами
CREATE TABLE order_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    ticket_type_id INT NOT NULL,
    ticket_price INT NOT NULL,
    barcode VARCHAR(120) UNIQUE,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (ticket_type_id) REFERENCES ticket_types(id)
);

orders — основная таблица для заказов.
ticket_types — справочная таблица с типами билетов.
order_tickets — таблица для детальной информации о каждом билете в заказе, с отдельными баркодами.
*/