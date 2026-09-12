<?php

session_start();
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: ../index.php');
    exit;
}


require 'connection.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['toast'] = 'ID de tarea inválido.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../index.php');
    exit;
}

$stmt = $conn->prepare('SELECT id FROM tasks WHERE id = ? AND user_id = ?');
$stmt->bind_param('ii', $id, $userId);
$stmt->execute();

$result = $stmt->get_result();
$task = $result->fetch_assoc();

$stmt->close();

if (!$task) {
    $_SESSION['toast'] = 'Tarea no encontrada.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../views/tasks.php');
    exit;
}

$stmt = $conn->prepare('DELETE FROM tasks WHERE id = ?');
$stmt->bind_param('i', $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    $_SESSION['toast'] = 'Tarea eliminada correctamente.';
    $_SESSION['toast_type'] = 'success';
} else {
    $_SESSION['toast'] = 'No se encontró la tarea.';
    $_SESSION['toast_type'] = 'error';
}

$stmt->close();

header('Location: ../views/tasks.php');
exit;