<?php
    require_once'./utils.php';
    session_start();
    $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <?php
        echo "<h1> Hola, ". $username ."</h1><br>";
        $idRol = buscarRol($username);
        $rol = ($idRol === 1)? 'admin': 'user';
        echo "<p>Tu rol es: $rol </p><br>";
    ?>
    <form action="./profile.php" method="post">
        <?php
            if ($rol == 'admin'){ ?>
            <input type="button" name='accion' value ="Lista Usuarios" onclick= "window.location.href = 'http://localhost/Sesion3/BBDD/listado.php'">
        <?php }; ?>
        <input type="button" name='accion' value="Cambiar Contraseña">
        <input type="button" name= 'accion' value="Cerrar Sesion">
</form>
</body>
</html>