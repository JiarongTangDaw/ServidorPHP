<?php
// Solo necesitamos utils + Usuario
require_once "./Usuario.php";
require_once "./utils.php";

// Siempre que se entra en login se borra la sesión actual
borrarSesion();

// Mensaje de error
$error = $_GET['error'] ?? '';

if ($error != "") {
    echo "<script>alert('" . $error . "');</script>";
}

// Sesión caducada
$action = $_GET['action'] ?? '';
if ($action == "sesioncaducada") {
    echo "<script>alert('La sesión ha caducado, inicia sesión de nuevo');</script>";
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login Administrador</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>Acceso Administrador</h1>

        <form method="post" id="formLogin">

            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" placeholder="Administrador" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>

            <button type="button" onclick="iniciarSesion()">Entrar</button>

        </form>

        <p><a href='./index.php'>Volver al inicio</a></p>
    </div>
</body>

</html>