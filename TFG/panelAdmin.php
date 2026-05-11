<?php
require_once "./utils.php";

// 🔒 Protección
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION["usuario"];

// Sección activa
$seccion = $_GET['seccion'] ?? 'marcas';

// ⚠️ Seguridad
$permitidas = ['marcas', 'modelos', 'tipoaccesorios', 'compatibilidades'];

if (!in_array($seccion, $permitidas)) {
    $seccion = 'marcas';
}

// Mensajes
$mensaje = $_GET['mensaje'] ?? '';
if ($mensaje != '') {
    echo "<script>alert('" . str_replace('--', '\\n', $mensaje) . "')</script>";
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>

<!-- 🔝 HEADER -->
<header class="topbar">
    <h2>Panel Admin</h2>
    <div>
        <span><?= $usuario->getUsuario(); ?></span>
        <button onclick="cerrarSesion()">Cerrar sesión</button>
    </div>
</header>

<div class="layout">

    <!-- 📚 SIDEBAR -->
    <aside class="sidebar">
        <ul>
            <li><a href="?seccion=marcas" class="<?= $seccion === 'marcas' ? 'active' : '' ?>">Marcas</a></li>
            <li><a href="?seccion=modelos" class="<?= $seccion === 'modelos' ? 'active' : '' ?>">Modelos</a></li>
            <li><a href="?seccion=tipoaccesorios" class="<?= $seccion === 'tipoaccesorios' ? 'active' : '' ?>">Tipos Accesorio</a></li>
            <li><a href="?seccion=compatibilidades" class="<?= $seccion === 'compatibilidades' ? 'active' : '' ?>">Compatibilidades</a></li>
        </ul>
    </aside>

    <!-- 🧾 CONTENIDO DINÁMICO -->
    <main class="contenido">
        <?php require "./" . $seccion . ".php"; ?>
    </main>

</div>

<!-- FORM ELIMINAR -->
<form method="post" id="frmEli" style="display:none;">
    <input type="hidden" name="idMarca" id="idMarca">
    <input type="hidden" name="idModelo" id="idModelo">
    <input type="hidden" name="idTipoAccesorio" id="idTipoAccesorio">
</form>

</body>
</html>