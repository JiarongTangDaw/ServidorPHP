<?php
    require_once "./utils.php";
    require_once './Contactos.php';
    require_once './Clientes.php';

    // Obtener todos los contactos para llenar el desplegable (select)
    $listaContactos = Contacto::obtenerTodos($pdo);

    // Verificamos si hay un ID en la URL. 
    // Si hay ID (!= 0), es modo EDICIÓN. Si no, es modo CREACIÓN.
    $cliente_id = isset($_GET['cliente_id'])? $_GET['cliente_id'] : 0;
    
    if($cliente_id != 0){
        // Si editamos, cargamos los datos del cliente de la BD
        $cliente = Cliente::obtenerPorId($pdo,$cliente_id);
    }

    // Gestión de errores devueltos por la validación
    $error = $_GET['error'] ?? '';

    if($error != ''){
        // Muestra alerta JS formateando los saltos de línea
        echo "<script>alert('" . str_replace("--", "\\n", $error) . "')</script>";
    }
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php if ($cliente_id == 0):?>
        <title>Nuevo Cliente</title>
    <?php else:?>
        <title>Modificar Cliente</title>
    <?php endif;?>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        
        <?php if ($cliente_id == 0):?>
            <h1>Nuevo Cliente</h1>
        <?php else:?>
            <h1>Modificar Cliente</h1>
        <?php endif;?>

        <form method="post" id= "formRegCliente">
            <input type="hidden" name="idCliente" id="idCliente">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder = "Nombre de cliente" required value="<?= $cliente_id != 0?  $cliente->getNombre(): '' ?>">

            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?= $cliente_id != 0? $cliente->getApellidos() : '' ?>">

            <label for="edad">Edad</label>
            <input type="number" id="edad" name="edad" placeholder="Edad de cliente" required value="<?= $cliente_id != 0?  $cliente->getEdad() : ''?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required value="<?= $cliente_id != 0? $cliente->getEmail() : ''?>">

            <label for="cif">CIF</label>
            <input type="text" id="cif" name="cif" placeholder="CIF" required value="<?= $cliente_id != 0? $cliente->getCIF() : ''?>">

            <label for="telefono">Telefono Españo:</label>
            <input type="text" id="telefono" name="telefono" placeholder="+34 6XX XXX XXX" required value="<?= $cliente_id != 0? $cliente->getTelefono() : ''?>">

            <label for="contacto">Contacto:</label>
            <select name="contacto" id="contacto">
                <option value="null" selected></option>
                <?php foreach ($listaContactos as $co): ?>
                    <option value="<?= $co->getId() ?>" <?= $cliente_id != 0 && $cliente->getContactoId() == $co->getId()? 'selected': '' ?> ><?= $co->getNombre() ?></option>
                <?php endforeach; ?>
            </select>
            
            <?php if ($cliente_id === 0):?>
                <button type="button" onclick="addCliente()">Crear Cliente</button>
            <?php else:?>
                <button type="button" onclick="modCliente(<?=$cliente->getId()?>)">Modificar Cliente</button>
            <?php endif;?>
            
        </form>
       <button class='cancelar' onclick="navegar('cliente')">Cancelar</button>
    </div>
</body>
</html>