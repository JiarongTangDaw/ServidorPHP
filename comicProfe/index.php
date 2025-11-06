<?php
require_once 'funciones.php';
$filtarea = '';
$filestado = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $filtarea = $_POST['tarea'];
    $filestado = $_POST['estado'];
}

$tareas = [];
$tareas = listarTareas($filtarea, $filestado);

?>

<html>

<head>
    <title>Gestion de Tareas</title>
    <script src="funciones.js"></script>
    <link rel="stylesheet" href="estilos.css">

</head>

<body>
    <form id="frm" name="frm" action="funciones.php" method="post">
        <input type="hidden" id="tarea" name="tarea">
        <input type="hidden" id="estado" name="estado">
        <input type="hidden" id="id" name="id">
        <div id="principal">
            <div id="cabecera">
                <div>Tarea</div>
                <div>Estados</div>
                <div>Botonera</div>
            </div>
            <div id="filtro">
                <div><input type="text" value="<?= $filtarea ?>"
                        id="filTarea" name="filTarea" onchange="filtrar()" /></div>
                <div>
                    <select id="filEstado" name="filEstado" onchange="filtrar()">
                        <option value=""></option>
                        <option value="pendiente" <?= $filestado === 'pendiente' ? 'selected' : '' ?>>pendiente
                        </option>
                        <option value="en progreso" <?= $filestado === 'en progreso' ? 'selected' : '' ?>>en
                            progreso</option>
                        <option value="completada" <?= $filestado === 'completada' ? 'selected' : '' ?>>completada
                        </option>
                    </select>
                </div>
            </div>
            <div id="listado">
                <?php
                    if($tareas == false){
                        echo "<h2> No hay tareas aun </h2>";
                    }else{
                        foreach ($tareas as $tarea) {
                        ?>
                <div><input type="text" id="tarea<?= $tarea->id ?>"
                        value="<?= $tarea->tarea ?>" />
                </div>
                <div> <select id="estado<?= $tarea->id ?>"
                        name="filEstado">
                        <option value=""></option>
                        <option value="pendiente" <?= $tarea->estado === 'pendiente' ? 'selected' : '' ?>>pendiente
                        </option>
                        <option value="en progreso" <?= $tarea->estado === 'en progreso' ? 'selected' : '' ?>>en
                            progreso</option>
                        <option value="completada" <?= $tarea->estado === 'completada' ? 'selected' : '' ?>>completada
                        </option>
                    </select>
                </div>
                <div>
                    <input type="button" id="btnAnadir" onclick="anadirFila();" value="ADD" />
                    <input type="button" id="btnAnadir"
                        onclick="modificar('<?= $tarea->id ?>');"
                        value="MOD" />
                    <input type="button" id="btnAnadir"
                        onclick="eliminar('<?= $tarea->id ?>');"
                        value="DEL" />
                </div>
                <?php
                        };};
?>
            </div>
        </div>
    </form>
</body>

</html>