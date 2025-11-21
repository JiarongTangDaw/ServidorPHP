<?php
session_start(); // Iniciar la sesión
// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre de usuario del formulario
    $usuario = $_POST['usuario'] ?? '';

    // Validar usuario (esto es el ejercicio2)
    if (empty($usuario)){// Si el usuario está vacío, mostrar un mensaje de error
        echo "El usuario no puede estar vacío.<br>";
    } else{// Si el usuario es válido, guardarlo en la sesión y redirigir a bienvenida.php
         $_SESSION['usuario'] = $usuario;
         //parte ejercicio3
         $_SESSION['login_time'] = time(); // Guardar el tiempo de inicio de sesión
         //fin parte ejercicio3
        header("Location: bienvenida.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" placeholder="Usuario">
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>

