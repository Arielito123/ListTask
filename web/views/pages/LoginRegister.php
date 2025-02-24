<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Login/Registro</title>
    <link rel="stylesheet" href="public/css/LoginRegister.css">
    
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#" method="post">
                <h1>Crear Cuenta</h1>
                <span>usa tu email para registrarte</span>
                <input type="text" placeholder="Nombre" name="name" />
                <input type="text" placeholder="Apellido" name="lastname" />
                <input type="email" placeholder="Email" name="mail" />
                <input type="text" placeholder="Telefono" name="phone" />
                <input type="password" placeholder="Contraseña" name="password"/>
                <button name="register">Registrar</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="#" method="post">
                <h1>Iniciar Sesión</h1>
                <span>usa tu cuenta</span>
                <input type="email" placeholder="Email" name="mail"/>
                <input type="password" placeholder="Contraseña" />
                <a href="#">¿Olvidaste tu contraseña?</a>
                <button name="login">Iniciar Sesión</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>¡Bienvenido de nuevo!</h1>
                    <p>Para mantenerte conectado con nosotros, inicia sesión con tu información personal</p>
                    <button class="ghost" id="signIn">Iniciar Sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>¡Hola!</h1>
                    <p>Ingresa tus datos personales y comienza tu viaje con nosotros</p>
                    <button class="ghost" id="signUp">Registrarse</button>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/LoginRegister.js"></script>
</body>
</html>
