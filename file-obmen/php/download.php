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
    die("Файл не указан.");
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM uploads WHERE id = ?");
$stmt->execute([$id]);
$file = $stmt->fetch();

if (!$file) {
    die("Файл не найден в базе.");
}

$path = $file['file_url'];

if (file_exists($path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($path).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    readfile($path);
    exit;
} else {
    echo "Файл отсутствует на сервере.";
}
?>
