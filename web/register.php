<?php
    
  
    include_once 'controllers/UserController.php';
    include_once 'controllers/MessageController.php';
    include_once 'models/UserModel.php';
    include_once 'config/MysqlDb.php';
  
    if (isset($_POST["registers"])) {
            $newUser = new UserController();
            $newUser->register();    
        }       
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/register.css">
  
</head>
<body>
    <div class="container">
        <h1>Crear Cuenta</h1>
        
        <form method="post" id="registroForm">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="name" required placeholder="Tu nombre">
            </div>
            
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="last_name" required placeholder="Tu apellido">
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="phone" required placeholder="Tu número de contacto">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" type="email" name="email" required placeholder="tucorreo@ejemplo.com">
                <div id="email-validation" class="validation-message" name="mail">Por favor, introduce un email válido</div>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required placeholder="Crea una contraseña segura">
                    <button type="button" class="toggle-password" onclick="togglePassword('password')">👁️</button>
                </div>
                <div id="password-validation" class="validation-message">La contraseña debe tener al menos 8 caracteres</div>
            </div>
            
            <div class="form-group">
                <label for="repeatPassword">Repetir Contraseña</label>
                <div class="password-container">
                    <input type="password" id="repeatPassword" name="repeatPassword" required placeholder="Repite tu contraseña">
                    <button type="button" class="toggle-password" onclick="togglePassword('repeatPassword')">👁️</button>
                </div>
                <div id="match-validation" class="validation-message">Las contraseñas no coinciden</div>
            </div>
            <?php
          MessageController::showMessageVerify("success", "Registro exitoso");
          MessageController::show_messages_error("letter", "El nombre o apellido debe contener solo letras");
          MessageController::show_messages_error("num", "El nombre o apellido debe tener menos de 70 caracteres");
          MessageController::show_messages_error("error", "no se pudo completar el registro");
          MessageController::show_messages_error("void", "El correo ya existe");
          MessageController::show_messages_error("duplicate", "El corrreo ya existe");
          MessageController::show_messages_error("email", "debe ser un correo valido");
            ?>             
            <button name="registers" type="submit">Registrarme</button>
        </form>

        <div class="login-link">
            ¿Ya tienes una cuenta? <a href="index.php">Iniciar Sesión</a>
        </div>
    </div>
</body>
</html>
<script src="public/js/register.js"></script>
<script src="public/js/close_notification.js"></script>



