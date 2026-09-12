<?php
session_start();
require 'connection.php';

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: ../index.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
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

$stmt = $conn->prepare(
    'SELECT id, title, description FROM tasks WHERE id = ?'
);
$stmt->bind_param('i', $id);
$stmt->execute();

$result = $stmt->get_result();
$task = $result->fetch_assoc();

$stmt->close();

if (!$task) {
    header('Location: ../views/tasks.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar tarea</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <main class="form-container">
        <section class="form-section">
            <h1>Editar tarea</h1>

            <form method="post" action="update_task.php">
                <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="<?= htmlspecialchars($task['title']) ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                    ><?= htmlspecialchars($task['description']) ?></textarea>
                </div>

                <button type="submit" class="save-button">
                    Actualizar
                </button>
            </form>

            <a href="../views/tasks.php" class="back-link">Volver</a>
        </section>
    </main>
</body>
</html>