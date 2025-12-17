<?php
    // Incluye las utilidades básicas
    require_once './utils.php';
    // Incluye la clase Usuario
    require_once './Usuarios.php';

    // Obtiene el ID del usuario a modificar desde la URL
    $usuario_id =(int) $_GET['usuario_id']?? 0;

    // Carga el objeto Usuario de la base de datos para pre-rellenar el formulario
    $user = Usuario::obtenerPorId($pdo, $usuario_id);

    // Muestra errores si vienen de la URL
    $error = $_GET['error']?? '';

    if($error != ""){
        echo "<script>
            alert('" . $error ."');
        </script>";
    }
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>Modificar Usuario</h1>

        <form method="post" id= "formModificar">
            <input type="hidden" name="idUsuario" id="idUsuario" >

            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" placeholder = "Nombre de usuario" required value="<?= $user->getUsuario()?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required value="<?= $user->getEmail()?>">

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" required value="<?= $user->getNombre()?>">

            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?= $user->getApellidos()?>">

        
            <label for='rol'>Rol</label>
            <select name='rol' id='rol'>
                <option value ='1' <?=$user->getRolId() === 1 ? 'selected' : ''?>> Admin</option>
                <option value ='2' <?=$user->getRolId() === 2 ? 'selected' : ''?>> Usuario</option>
            </select>


            <button onclick="modUsuario(<?=$user->getId()?>)">Modificar Usuario</button>
        </form>
        <button class='cancelar' onclick="navegar('usuario')">Cancelar</button>
    </div>
</body>

</html>