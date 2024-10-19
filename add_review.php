<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить отзыв</title>
</head>
<body>
    <h1>Добавить отзыв</h1>
    <form method="POST" action="add_review.php">
        <label for="name">Имя:</label>
        <input type="text" name="name" required>
        <br>
        <label for="review">Отзыв:</label>
        <textarea name="review" required></textarea>
        <br>
        <label for="rating">Рейтинг:</label>
        <input type="number" name="rating" min="1" max="5" required>
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
            $name = $_POST['name'];
            $review = $_POST['review'];
            $rating = (int) $_POST['rating'];

            $sql = "INSERT INTO reviews (name, review, rating) VALUES (:name, :review, :rating)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'review' => $review, 'rating' => $rating]);
            echo "Отзыв успешно добавлен!";
        }

        // Отображение отзывов
        $sql = "SELECT * FROM reviews";
        $stmt = $pdo->query($sql);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Отзывы:</h2>";
        foreach ($reviews as $review) {
            echo "<p><strong>{$review['name']}</strong>: {$review['review']} (Рейтинг: {$review['rating']})</p>";
        }
    } catch (PDOException $e) {
        echo 'Ошибка подключения: ' . $e->getMessage();
    }
    ?>
</body>
</html>
