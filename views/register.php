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

            <h1>Register</h1>

            <form id="register-form" method="post">
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

                <p class="register-message"></p>

                <button type="submit" class="save-button">Registrarse</button>
            </form>

            <p class="auth-link">
                ¿Ya tienes cuenta? <a href="../index.php">Inicia sesión aquí</a>
            </p>
        </section>
    </main>
    <script src="../JS/register.js"></script>
</body>

</html>
