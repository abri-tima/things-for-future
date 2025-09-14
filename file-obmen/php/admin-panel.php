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

// Получаем все файлы
$stmt = $pdo->query("SELECT * FROM uploads ORDER BY uploaded_at DESC");
$files = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <style>
        body { font-family: Arial, sans-serif; padding:20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border:1px solid #ccc; padding:8px; text-align: left; }
        th { background:#f4f4f4; }
        a.button { padding:5px 10px; border:1px solid #333; border-radius:5px; text-decoration:none; margin:2px; }
        a.download { background:#4CAF50; color:white; }
        a.delete { background:#f44336; color:white; }
    </style>
</head>
<body>
    <h2>Админ-панель: загруженные файлы</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Файл</th>
            <th>Дата</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($files as $file): ?>
        <tr>
            <td><?= $file['id'] ?></td>
            <td><?= htmlspecialchars($file['name']) ?></td>
            <td><a href='<?= htmlspecialchars($file['file_url']) ?>' target='_blank'><?= basename($file['file_url']) ?></a></td>
            <td><?= $file['uploaded_at'] ?></td>
            <td>
                <a class="button download" href="download.php?id=<?= $file['id'] ?>">Скачать файл</a>
                <a class="button delete" href="delete.php?id=<?= $file['id'] ?>" onclick="return confirm('Удалить файл?')">Удалить файл</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
