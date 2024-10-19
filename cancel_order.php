<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отмена заказа</title>
</head>
<body>
    <h1>Отменить заказ</h1>
    <form method="POST" action="cancel_order.php">
        <label for="order_id">Номер заказа:</label>
        <input type="text" name="order_id" required>
        <br>
        <label for="reason">Причина отмены:</label>
        <textarea name="reason" required></textarea>
        <br>
        <input type="submit" value="Отправить">
    </form>

    <?php
    $dsn = 'mysql:host=localhost;dbname=shop';
    $username = 'root2';
    $password = '123456789';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_id = $_POST['order_id'];
            $reason = $_POST['reason'];

            $sql = "INSERT INTO cancellations (order_id, reason) VALUES (:order_id, :reason)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['order_id' => $order_id, 'reason' => $reason]);
            echo "Заказ #$order_id успешно отменен!";
        }
    } catch (PDOException $e) {
        echo 'Ошибка подключения: ' . $e->getMessage();
    }
    ?>
</body>
</html>
