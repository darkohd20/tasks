<?php

session_start();

require 'connection.php';

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: ../index.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($title === '' || $description === '') {
    $_SESSION['toast'] = 'Title y Description son obligatorios.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../views/tasks.php');
    exit;
}

$sql = 'INSERT INTO tasks (title, description, user_id, created_at) VALUES (?, ?, ?, NOW())';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssi', $title, $description, $userId);

if ($stmt->execute()) {
    $_SESSION['toast'] = 'Tarea guardada correctamente.';
    $_SESSION['toast_type'] = 'success';
} else {
    $_SESSION['toast'] = 'No se pudo guardar la tarea.';
    $_SESSION['toast_type'] = 'error';
}

$stmt->close();

header('Location: ../views/tasks.php');
exit;