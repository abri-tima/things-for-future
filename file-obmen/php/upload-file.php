<?php
// Подключение к БД
$host = "localhost"; 
$db   = "u927626197_file_obmen"; 
$user = "u927626197_file_user"; 
$pass = "UserFile20252411TT"; 
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (Exception $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

// Работа с загрузкой
if (isset($_POST["username"]) && isset($_FILES["fileToUpload"])) {
    $username = preg_replace("/[^a-zA-ZА-Яа-яЁёЇїІіЄєҐґ0-9_\-]/u", "_", $_POST["username"]);

    $targetDir = "uploads/" . $username . "/";

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $targetFile = $targetDir . $fileName;

    // Загружаем файл, перезаписывая если уже есть
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {

        // Проверяем, есть ли уже запись в БД
        $stmtCheck = $pdo->prepare("SELECT id FROM uploads WHERE name = ? AND file_url = ?");
        $stmtCheck->execute([$username, $targetFile]);
        $existing = $stmtCheck->fetch();

        if ($existing) {
            // Если запись есть, можно просто не делать INSERT
            echo "<div class='upload-success'>";
            echo "<p class='upload-message'>Файл успешно обновлён!</p>";
        } else {
            // Если записи нет, создаём новую
            $stmt = $pdo->prepare("INSERT INTO uploads (name, file_url) VALUES (?, ?)");
            $stmt->execute([$username, $targetFile]);

            echo "<div class='upload-success'>";
            echo "<p class='upload-message'>Файл успешно загружен!</p>";
        }

        echo "<p class='upload-username'>Имя: <span class='username'>" . htmlspecialchars($username) . "</span></p>";
        echo "<p class='upload-link'><a class='download-link' href='" . htmlspecialchars($targetFile) . "' target='_blank' download>Скачать файл</a></p>";
        echo "</div>";

    } else {
        echo "<div class='upload-error'>Ошибка загрузки файла.</div>";
    }

} else {
    echo "<div class='upload-error'>Не все данные переданы!</div>";
}
?>
