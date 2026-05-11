<?php
require_once "./utils.php";
require_once './TipoAccesorio.php';

// Detectar edición
$tipoaccesorio_id = isset($_GET['tipoaccesorio_id']) 
    ? (int)$_GET['tipoaccesorio_id'] 
    : 0;

if ($tipoaccesorio_id != 0) {
    $tipo = TipoAccesorio::obtenerPorId($pdo, $tipoaccesorio_id);
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
        <?= $tipoaccesorio_id == 0 
            ? 'Nuevo Tipo Accesorio' 
            : 'Modificar Tipo Accesorio' ?>
    </title>

    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>

<div class="container">

    <h1>
        <?= $tipoaccesorio_id == 0 ? 'Nuevo Tipo Accesorio' : 'Modificar Tipo Accesorio' ?>
    </h1>

    <form method="post" id="formRegTipo">

        <input type="hidden" name="idTipoAccesorios" id="idTipoAccesorios" value="<?= $tipoaccesorio_id ?>">
        <input type="hidden" name="idTipoAccesorio" id="idTipoAccesorio">

        <label for="tipoaccesorio">Tipo Accesorio</label>

        <input
            type="text"
            name="tipoaccesorio"
            id="tipoaccesorio"
            placeholder="Nombre del tipo accesorio"
            required
            value="<?= $tipoaccesorio_id != 0 
                ? $tipo->getTipoAccesorio() 
                : '' ?>"
        >

        <?php if ($tipoaccesorio_id == 0): ?>

            <button type="button" onclick="addTipoAccesorio()">
                Crear Tipo Accesorio
            </button>

        <?php else: ?>

            <button type="button" onclick="modTipoAccesorio(<?= $tipoaccesorio_id ?>)">
                Modificar Tipo Accesorio
            </button>

        <?php endif; ?>

    </form>

    <button 
        class="cancelar"
        onclick="window.location.href='panelAdmin.php?seccion=tipoaccesorios'"
    >
        Cancelar
    </button>

</div>

</body>
</html>