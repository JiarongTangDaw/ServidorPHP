<?php
require_once "./utils.php";
require_once './Modelo.php';
require_once './Marca.php';

// Obtener marcas para el SELECT
$listaMarcas = Marca::obtenerTodos($pdo);

// Detectar edición
$modelo_id = isset($_GET['modelo_id']) 
    ? (int)$_GET['modelo_id'] 
    : 0;

if ($modelo_id != 0) {
    $modelo = Modelo::obtenerPorId($pdo, $modelo_id);
}

// Gestión errores
$error = $_GET['error'] ?? '';

if ($error != '') {
    echo "<script>alert('" . str_replace('--', '\\n', $error) . "')</script>";
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>
        <?= $modelo_id == 0 ? 'Nuevo Modelo' : 'Modificar Modelo' ?>
    </title>

    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>

<div class="container">

    <h1>
        <?= $modelo_id == 0 ? 'Nuevo Modelo' : 'Modificar Modelo' ?>
    </h1>

    <form method="post" id="formRegModelo">

        <input  type="hidden" name="idModelos" id="idModelos" value="<?= $modelo_id ?>" >
        <input  type="hidden" name="idModelo" id="idModelo" >

        <label for="modelo">Modelo</label>

        <input type="text"
            name="modelo"
            id="modelo"
            placeholder="Nombre del modelo"
            required
            value="<?= $modelo_id != 0 
                ? $modelo->getModelo() 
                : '' ?>"
        >

        <!-- MARCA -->

        <label for="marca_id">Marca</label>

        <select name="marca_id" id="marca_id" required>

            <option value="">Seleccione una marca</option>

            <?php foreach ($listaMarcas as $m): ?>

                <option 
                    value="<?= $m->getId() ?>"

                    <?= $modelo_id != 0 
                        && $modelo->getMarcaId() == $m->getId()
                        ? 'selected'
                        : '' ?>
                >
                    <?= $m->getMarca() ?>
                </option>

            <?php endforeach; ?>

        </select>

        <?php if ($modelo_id == 0): ?>

            <button type="button" onclick="addModelo()">
                Crear Modelo
            </button>

        <?php else: ?>

            <button type="button" onclick="modModelo(<?= $modelo_id ?>)">
                Modificar Modelo
            </button>

        <?php endif; ?>

    </form>

    <button 
        class="cancelar"
        onclick="window.location.href='panelAdmin.php?seccion=modelos'"
    >
        Cancelar
    </button>

</div>

</body>
</html>