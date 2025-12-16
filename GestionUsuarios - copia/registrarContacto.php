<?php
    require_once "./utils.php";
    require_once './Contactos.php';

    $contacto_id = isset($_GET['contacto_id'])? $_GET['contacto_id'] : 0;
    if($contacto_id != 0){
        $contacto = Contacto::obtenerPorId($pdo,$contacto_id);
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
    <?php if ($contacto_id == 0):?>
        <title>Nuevo Contacto</title>
    <?php else:?>
        <title>Modificar Contacto</title>
    <?php endif;?>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        <?php if ($contacto_id == 0):?>
            <h1>Nuevo Contacto</h1>
        <?php else:?>
            <h1>Modificar Contacto</h1>
        <?php endif;?>

        <form method="post" id= "formRegContacto">
            <input type="hidden" name="idContacto" id="idContacto">

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" required value="<?= $contacto_id != 0? $contacto->getNombre() : '' ?>">

            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?= $contacto_id != 0? $contacto->getApellidos() : '' ?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required value="<?= $contacto_id != 0? $contacto->getEmail() : '' ?>">

            <label for="telefono">Telefono Español</label>
            <input type="text" name="telefono" id="telefono" placeholder = "+34 6XX XXX XXX" required value="<?= $contacto_id != 0? $contacto->getTelefono() : '' ?>">

             <?php if ($contacto_id === 0):?>
                <button type="button" onclick="addContacto()">Crear Contacto</button>
            <?php else:?>
                <button type="button" onclick="modContacto(<?=$contacto->getId()?>)">Modificar Contacto</button>
            <?php endif;?>
        </form>
        <button class='cancelar' onclick="navegar('contacto')">Cancelar</button>
</body>

</html>