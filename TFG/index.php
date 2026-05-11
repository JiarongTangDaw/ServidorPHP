<?php
require_once "./utils.php";
require_once "./TipoAccesorio.php";

borrarSesion();

$mensaje = $_GET['mensaje'] ?? '';

if ($mensaje != '') {
    echo "<script>alert('" . $mensaje . "');</script>";
}

$tipos = TipoAccesorio::obtenerTodos($pdo);
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="./style.css">
    <title>Buscador de Compatibilidades</title>
    <script src="./script.js" defer></script>
</head>

<body>

<!-- 🔝 BARRA SUPERIOR -->
<header class="topbar">
    <h2>Compatibilidades</h2>
    <button onclick="login()">Login Admin</button>
</header>

<div class="container">

    <h1>Buscar Compatibilidades</h1>

    <!-- 🔍 FORMULARIO AJAX -->
    <form id="formBusqueda">

        <!-- MODELO -->
        <label>Modelo</label>
        <input type="text" id="modelo1" placeholder="Escribe modelo..." autocomplete="off">
        <input type="hidden" id="modelo1_id">
        <ul id="sugerencias_modelo"></ul>

        <!-- TIPO ACCESORIO -->
        <select id="tipoaccesorio_id" name="tipoaccesorio_id">
            <option value="">-- Selecciona tipo --</option>
            <?php foreach ($tipos as $tipo): ?>
                <option value="<?= htmlspecialchars($tipo->getId()) ?>">
                    <?= htmlspecialchars($tipo->getTipoAccesorio()) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Buscar</button>
    </form>

    <!-- 🔥 RESULTADOS SIN RECARGA -->
    <div id="resultados"></div>

</div>

</body>

</html>