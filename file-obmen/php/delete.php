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
$pdo = new PDO($dsn, $user, $pass, $options);

if (!isset($_GET['id'])) {
    die("ID не указан.");
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM uploads WHERE id = ?");
$stmt->execute([$id]);
$file = $stmt->fetch();

if ($file) {
    $path = $file['file_url'];

    // Удаляем файл
    if (file_exists($path)) {
        unlink($path);

        $dir = dirname($path);
        if (is_dir($dir)) {
            $filesLeft = glob($dir . "/*"); // смотрим, остались ли файлы
            if (empty($filesLeft)) {
                rmdir($dir); // удаляем папку, если пустая
            }
        }
    }

    // Удаляем запись
    $stmt = $pdo->prepare("DELETE FROM uploads WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: admin-panel.php");
    exit;
} else {
    echo "Файл не найден в базе.";
}
?>
