<?php
session_start();

$toast = $_SESSION['toast'] ?? null;
$toastType = $_SESSION['toast_type'] ?? 'success';

unset($_SESSION['toast'], $_SESSION['toast_type']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <main class="auth-container">
        <section class="auth-section">
            <?php if ($toast): ?>
                <input type="checkbox" id="close-toast" class="toast-checkbox">

                <div class="toast <?= htmlspecialchars($toastType) ?>">
                    <span><?= htmlspecialchars($toast) ?></span>
                    <label for="close-toast" class="toast-close">&times;</label>
                </div>
            <?php endif; ?>

            <h1>Register</h1>

            <form method="post" action="../php/register.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>

                <button type="submit" class="save-button">Registrarse</button>
            </form>

            <p class="auth-link">
                ¿Ya tienes cuenta? <a href="../index.php">Inicia sesión aquí</a>
            </p>
        </section>
    </main>
</body>

</html>