<?php

session_start();

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header('Location: ../index.php');
    exit;
}

require 'connection.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$stmt = $conn->prepare('SELECT id FROM tasks WHERE id = ? AND user_id = ?');
$stmt->bind_param('ii', $id, $userId);
$stmt->execute();

$result = $stmt->get_result();
$task = $result->fetch_assoc();

$stmt->close();

if (!$task) {
    $_SESSION['toast'] = 'Tarea no encontrada.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../index.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');

if (!$id || $title === '' || $description === '') {
    $_SESSION['toast'] = 'Todos los campos son obligatorios.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../index.php');
    exit;
}

$stmt = $conn->prepare(
    'SELECT id FROM tasks WHERE title = ? AND id != ?'
);
$stmt->bind_param('si', $title, $id);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    $stmt->close();

    $_SESSION['toast'] = 'Ya existe una tarea con ese título.';
    $_SESSION['toast_type'] = 'error';
    header('Location: edit_task.php?id=' . $id);
    exit;
}

$stmt->close();

$stmt = $conn->prepare(
    'UPDATE tasks SET title = ?, description = ? WHERE id = ?'
);
$stmt->bind_param('ssi', $title, $description, $id);

if ($stmt->execute()) {
    $_SESSION['toast'] = 'Tarea actualizada correctamente.';
    $_SESSION['toast_type'] = 'success';
} else {
    $_SESSION['toast'] = 'No se pudo actualizar la tarea.';
    $_SESSION['toast_type'] = 'error';
}

$stmt->close();

header('Location: ../views/tasks.php');
exit;