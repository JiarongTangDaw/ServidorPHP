<?php
require_once "./utils.php";
require_once './Marca.php';

// Detectar si es edición
$marca_id = isset($_GET['marca_id']) ? (int)$_GET['marca_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($marca_id != 0) {
    $marca = Marca::obtenerPorId($pdo, $marca_id);
}

// Gestión de errores
$error = $_GET['error'] ?? '';

if ($error != '') {
    echo "<script>alert('" . str_replace('--', '\\n', $error) . "')</script>";
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title><?= $marca_id == 0 ? 'Nueva Marca' : 'Modificar Marca' ?></title>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">

        <h1><?= $marca_id == 0 ? 'Nueva Marca' : 'Modificar Marca' ?></h1>

        <form method="post" id="formRegMarca">
            <input type="hidden" name="idMarcas" id="idMarcas" value="<?= $marca_id ?>">
            <input type="hidden" name="idMarca" id="idMarca">

            <label for="marca">Marca</label>
            <input type="text" 
                   name="marca" 
                   id="marca" 
                   placeholder="Nombre de la marca" 
                   required 
                   value="<?= $marca_id != 0 ? $marca->getMarca() : '' ?>">

            <?php if ($marca_id == 0): ?>
                <button type="button" onclick="addMarca()">Crear Marca</button>
            <?php else: ?>
                <button type="button" onclick="modMarca(<?= $marca_id ?>)">Modificar Marca</button>
            <?php endif; ?>

        </form>

        <button class="cancelar" onclick="window.location.href='panelAdmin.php?seccion=marcas'">
            Cancelar
        </button>

    </div>
</body>
</html>