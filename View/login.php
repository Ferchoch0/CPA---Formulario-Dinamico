<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPA</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <main>
        <div class="formulario-container"> 
            <form action="" id="form">
                <h1 class="formulario-titulo">Inicio de sesión</h1>
                <div class="form-campos">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-campos">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-boton">
                    <button type="submit" class="button">Iniciar</button>
                </div>
                <div class="form-footer">
                    <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
                </div>
            </form>
        </div>
    </main>
    
</body>
</html>