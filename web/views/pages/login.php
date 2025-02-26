<?php
if(isset($_POST['login'])) {
    $user= new UserController();
    $user->control_login();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>

        <form method="post" id="loginForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="mail" required placeholder="tucorreo@ejemplo.com">
                <div id="email-validation" class="validation-message">Por favor, introduce un email válido</div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required placeholder="Tu contraseña">
                    <button type="button" class="toggle-password" onclick="togglePassword('password')">👁️</button>
                </div>
                <div id="password-validation" class="validation-message">Ingrese su contraseña</div>
            </div>
            <button name="login" type="submit">Ingresar</button>
            <?php MessageController::show_messages_error('verify','el email o la contraseña son incorrectos')?>
            <?php MessageController::show_messages_error('void','no pueden haber campos vacios')?>
        </form>

        <div class="register-link">
            ¿No tienes una cuenta? <a href="../register.php">Regístrate</a>
        </div>
    </div>
</body>
</html>
<script src="public/js/close_notification.js"></script>
<script src="public/js/login.js"></script>
