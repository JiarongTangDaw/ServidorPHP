<?php
    require_once "./utils.php";
    require_once './Usuarios.php';


    $usuario_id = isset($_GET['usuario_id'])? $_GET['usuario_id'] : 0;
    $listado = isset($_GET['listado'])? $_GET['listado'] : false;
    if($usuario_id != 0){
        $user = Usuario::obtenerPorId($pdo,$usuario_id);
    }
    if (isset($_SESSION["usuario"])) {
        $usu_conectado = $_SESSION["usuario"];
        $idUsuarioConectado = $usu_conectado->getId();
    }

    $error = $_GET['error'] ?? '';

    if($error != ''){
        echo "<script>alert('" . str_replace("--", "\\n", $error) . "')</script>";
    }
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php if ($usuario_id == 0):?>
        <title>Nuevo Usuario</title>
    <?php else:?>
        <title>Modificar Usuario</title>
    <?php endif;?>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        
        <?php if ($usuario_id == 0):?>
            <h1>Nuevo Usuario</h1>
        <?php else:?>
            <h1>Modificar Usuario</h1>
        <?php endif;?>

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

            <?php if ($usuario_id == 0 || $usuario_id == $idUsuarioConectado):?>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" <?=$usuario_id === 0 ? 'required' : ''?> value="">
            <?php endif;?>

            <?php if ($usuario_id != 0):?>
                <label for='rol'>Rol</label>
                <select name='rol' id='rol'>
                    <option value ='1' <?=$user->getRolId() === 1 ? 'selected' : ''?>> Admin</option>
                    <option value ='2' <?=$user->getRolId() === 2 ? 'selected' : ''?>> Usuario</option>
                </select>
            <?php endif;?>

            <?php if ($usuario_id != 0):?>
                <button onclick="modUsuario(<?=$user->getId()?>)">Modificar Usuario</button>
            <?php else:?>
                 <button onclick="addUsuario(<?= $listado ?>)">Crear Usuario</button>
            <?php endif;?>
        </form>
       <button class='cancelar' onclick="navegar('usuario')">Cancelar</button>
    </div>
</body>

</html>