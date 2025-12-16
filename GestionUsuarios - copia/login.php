<?php
//Incluyo mi clases necesarias
require_once "./Usuarios.php";
require_once "./Roles.php";

//Me traigo el fichero que tiene todas las librerias básicas del proyecto
require_once "./utils.php";

//Siempre que entro en login me cargo la sesion
borrarSesion();

$error = $_GET['error']?? '';

if($error != ""){
    echo "<script>
        alert('" . $error ."');
    </script>";
}

$action = $_GET['action']??'';
if($action == "sesioncaducada"){
    echo "<script>
        alert('La sesion ha caducado, por favor inicie seesion de nuevo.');
    </script>";
}

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login Usuario</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>Login Usuario</h1>

        <form method="post" id="formLogin">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" placeholder="Nombre de usuario"  >

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="••••••••"  value="">
            
            <button onclick="iniciarSesion()">Iniciar Sesion</button>
        </form>

        <p>No tengo una cuenta: <a href="./index.php">Inicio</a></p>
    </div>
</body>

</html>