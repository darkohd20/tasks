<?php

require 'connection.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header('Location: index.php');
    exit;
}

$tasks = [];

$stmt = $conn->prepare(
    'SELECT id, title, description, created_at
     FROM tasks
     WHERE user_id = ?
     ORDER BY created_at DESC'
);

if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}


$stmt->bind_param('i', $userId);
$stmt->execute();

$result = $stmt->get_result();

while ($task = $result->fetch_assoc()) {
    $tasks[] = $task;
}

$stmt->close();