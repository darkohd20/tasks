
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <main class="auth-container">
        <section class="auth-section">

            <h1>Login</h1>

            <form id="formulario-login" method="post" >
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                    <p class="validation-1"></p>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <p class="validation-2"></p>
                </div>

                <button type="submit" class="save-button">Ingresar</button>
            </form>

            <p class="auth-link">
                ¿No tienes cuenta? <a href="views/register.php">Regístrate aquí</a>
            </p>
        </section>
    </main>
    <script src="js/login.js"></script>
</body>

</html>