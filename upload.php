<?php
// Проверка, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, заполнено ли поле file_name
    if (empty($_POST['file_name'])) {
        header('Location: index.html'); // Редирект на форму
        exit();
    }

    // Проверяем, был ли загружен файл
    if (!isset($_FILES['content']) || $_FILES['content']['error'] !== UPLOAD_ERR_OK) {
        header('Location: index.html'); // Редирект на форму
        exit();
    }

    // Получаем имя файла и путь сохранения
    $file_name = basename($_POST['file_name']);
    $upload_dir = 'upload/';
    $upload_file = $upload_dir . $file_name;

    // Создаем директорию, если она не существует
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Перемещаем загруженный файл в указанную директорию
    if (move_uploaded_file($_FILES['content']['tmp_name'], $upload_file)) {
        // Отображаем путь к сохраненному файлу и его размер
        echo "Файл успешно загружен!<br>";
        echo "Полный путь к файлу: " . realpath($upload_file) . "<br>";
        echo "Размер файла: " . $_FILES['content']['size'] . " байт";
    } else {
        echo "Ошибка при загрузке файла.";
    }
} else {
    header('Location: index.html'); // Редирект на форму, если не POST запрос
    exit();
}
?>
