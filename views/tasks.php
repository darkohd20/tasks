<?php

session_start();

$userName = $_SESSION['user_name'] ?? null;

if (!$userName) {
    header('Location: ../index.php');
    exit;
}

require_once '../php/get_tasks.php';

$toast = $_SESSION['toast'] ?? null;
$toastType = $_SESSION['toast_type'] ?? 'success';

unset($_SESSION['toast'], $_SESSION['toast_type']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaksPav | Tareas</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <span class="navbar-brand">TaksPav</span>
            <div class="navbar-right">
                <span class="navbar-user">
                    Hola, <?= htmlspecialchars($userName) ?>
                </span>
                <a href="../php/logout.php" class="navbar-logout">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <main class="container">
        <section class="form-section">
            <?php if ($toast): ?>
                <input type="checkbox" id="close-toast" class="toast-checkbox">

                <div class="toast <?= htmlspecialchars($toastType) ?>">
                    <span><?= htmlspecialchars($toast) ?></span>
                    <label for="close-toast" class="toast-close">&times;</label>
                </div>
            <?php endif; ?>

            <h1>Add Task</h1>

            <form method="post" action="../php/save_task.php">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="6"></textarea>
                </div>

                <button type="submit" class="save-button">Guardar</button>
            </form>
        </section>

        <section class="table-section">
            <h1>Tasks</h1>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tasks)): ?>
                            <tr>
                                <td colspan="4" class="empty-message">
                                    No hay tareas registradas
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?= htmlspecialchars($task['title']) ?></td>
                                    <td><?= htmlspecialchars($task['description']) ?></td>
                                    <td><?= htmlspecialchars($task['created_at']) ?></td>
                                    <td>
                                        <a href="../php/edit_task.php?id=<?= (int) $task['id'] ?>"
                                            class="action-button"
                                            title="Editar">✏️</a>
                                        <a href="../php/delete_task.php?id=<?= (int) $task['id'] ?>"
                                            class="action-button delete" title="Eliminar">🗑️</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>