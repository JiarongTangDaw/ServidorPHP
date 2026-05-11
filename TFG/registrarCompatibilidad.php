<?php
require_once "./utils.php";
require_once "./Modelo.php";
require_once "./TipoAccesorio.php";
require_once "./Marca.php";

// 🔥 Obtener modelos y tipos accesorio
$listaModelos = Modelo::obtenerTodos($pdo);
$listaTipos = TipoAccesorio::obtenerTodos($pdo);

$mapaMarcas = [];
foreach (Marca::obtenerTodos($pdo) as $marca) {
    $mapaMarcas[$marca->getId()] = $marca->getMarca();
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
    <title>Nueva Compatibilidad</title>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>

<div class="container">

    <h1>Nueva Compatibilidad</h1>

    <form method="post" id="formRegCompatibilidad">

        <label for="modelo1_id">Modelo 1</label>
        <select name="modelo1_id" id="modelo1_id" required>
            <option value="">Seleccione un modelo</option>
            <?php foreach ($listaModelos as $m): ?>
                <option value="<?= $m->getId() ?>">
                    <?= $mapaMarcas[$m->getMarcaId()] ?> - <?= $m->getModelo() ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="modelo2_id">Modelo 2</label>
        <select name="modelo2_id" id="modelo2_id" required>
            <option value="">Seleccione un modelo</option>
            <?php foreach ($listaModelos as $m): ?>
                <option value="<?= $m->getId() ?>">
                    <?= $mapaMarcas[$m->getMarcaId()] ?> - <?= $m->getModelo() ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="tipoaccesorio_id">Tipo Accesorio</label>
        <select name="tipoaccesorio_id" id="tipoaccesorio_id" required>
            <option value="">Seleccione un tipo accesorio</option>
            <?php foreach ($listaTipos as $t): ?>
                <option value="<?= $t->getId() ?>">
                    <?= $t->getTipoAccesorio() ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="button" onclick="addCompatibilidad()">
            Crear Compatibilidad
        </button>

    </form>

    <button class="cancelar" onclick="window.location.href='panelAdmin.php?seccion=compatibilidades'">
        Cancelar
    </button>

</div>

</body>
</html>