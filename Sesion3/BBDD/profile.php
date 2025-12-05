<?php
    require_once './utils.php';
    session_start();
    $username = $_SESSION['username'];

    if(isset($_SESSION['mensaje'])){
        echo "<script>
                    alert('".$_SESSION['mensaje']."')
                    </script>";
        unset($_SESSION['mensaje']);
    }

    if(isset($_SESSION['error'])){
        echo "<script>
                    alert('".$_SESSION['error']."')
                    </script>";
        unset($_SESSION['error']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <script src="./funciones.js" defer></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        echo "<h1> Hola, ". $username ."</h1><br>";
        $idRol = buscarRol($username);
        $rol = ($idRol === 1)? 'admin': 'user';
        echo "<p>Tu rol es: $rol </p><br>";
    ?>
    <div class='botones'>
        <?php
            if ($rol == 'admin'){ ?>
                <button class='btPerfil' onClick= "window.location.href = 'http://localhost/Sesion3/BBDD/listado.php'">Lista Usuarios</button>
        <?php }; ?>
        <button class='btPerfil' onClick= "mostrarCambioPass()">Cambiar Contraseña</button>
        <button class='btPerfil' onClick="cerrarSesion()">Cerrar Sesion</button>
    </div>

    <div id="cambio" style="display: none;">
        <?php
            $idUser = buscarId($username);
        ?>
        <h2>Cambiar Contraseña</h2>
        <form action="./profile.php" method="post" id="formCambioPass">
            <input type="hidden" name="newPassword" id="password">
            <input type="hidden" name="oldPassword" id="password2">
            <input type="hidden" name="id" id="id">


            <label for="oldPassword">Contraseña actual:</label>
            <input type="password" id="oldPassword">
            <label for="newPassword">Contraseña nueva:</label>
            <input type="password" id="newPassword">
            <label for="newPassword2">Confirmar contraseña nueva:</label>
            <input type="password" id="newPassword2">
            <input type="button" class="login" value="Cambiar Contraseña" onClick="modificarPassword('<?= $idUser ?>')">
        </form>
        <button class="volver" onclick="mostrarCambioPass()">Cancelar</button>
    </div>
</body>
</html>