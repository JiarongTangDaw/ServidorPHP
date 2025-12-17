<?php

// Me traigo el fichero que tiene todas las librerias básicas del proyecto (incluye utils y sesion)
require_once "./utils.php";

// Siempre que se entra en la página de inicio, se fuerza el cierre de sesión existente
borrarSesion();

// Obtiene un mensaje de la URL si existe (ej. mensaje de cierre de sesión exitoso)
$mensaje = $_GET['mensaje']?? '';

// Si hay mensaje, lo muestra en una alerta de JavaScript
if($mensaje != ''){
    echo "<script>
        alert('" . $mensaje ."');
    </script>";
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="./style.css">
    <title>Inicio</title>
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        <form id="frmInicio" name="frmInicio" action="" method="post">
            <h1>Bienvenido</h1>
            <button class="btn primary" onclick="registrar()">Crear nuevo usuario</button>
            <button class="btn secondary" onclick="login()">Login</button>
        </form>
    </div>
</body>

</html>