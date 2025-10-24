<?php
require 'funciones.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de tareas</title>
    <link rel="stylesheet" href="styles.css">
    <script src="./funciones.js" defer></script>
</head>
<body>
    <h1>Gestión de tareas</h1>

    <div id="botones">
        <button class="add" id="btAdd">
                Agregar Tarea
        </button>
        <button class="delete" id="btDelete">
                Eliminar Tarea
        </button>
        <button class="edit" id="btEdit">
                Editar Tarea
        </button>
    </div>

    <div id="formulario">
        <h2 id="add">Agregar Tarea</h2>
        <h2 id="delete">Eliminar Tarea</h2>
        <h2 id="edit">Editar Tarea</h2>
        <form action="funciones.php" id="form" method="POST">
            <input type="text" name="tarea" id="tarea" placeholder="Nombre tarea">
            <input type="text" name="idTarea" id="idTarea" placeholder="Id Tarea">
            <select name="estado" id="estado">
                <option value="pendiente">Pendiente</option>
                <option value="en_progreso">En progreso</option>
                <option value="completo">Completo</option>
            </select>
            <button type="submit" class="add" id="btAgregar" value="add">
                Agregar Tarea
            </button>
            <button type="submit" class="delete" id="btElim" value="delete">
                Eliminar Tarea
            </button>
            <button type="submit" class="edit" id="btEditar" value="edit">
                Editar Tarea
            </button>
        </form>
    </div>
    <div id="listaTarea">
        <h2>Lista Tareas</h2>
        <?php
$tareas = leerFichero('tareas.txt');
$table = visualizarTarea($tareas);
echo $table;
?>
        <!-- <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TAREA</th>
                    <th>ESTADO</th>
                    <-- <th>BOTONES</th> ->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>hiosljfjso</td>
                    <td>pendiente</td>
                    <-- <td id="elimEdit">
                        <button type="submit" class="delete" id="btElim">
                            Eliminar Tarea
                        </button>
                        <button type="submit" class="edit" id="btEditar">
                            Editar Tarea
                        </button>
                    </td> ->
                </tr>
            </tbody>
        </table> -->
        
    </div>
    <!-- <div>
        <?php
//     require 'funciones.php';
// $l = leerFichero("tareas.txt");
// print_r($l);
// addId($l);
// print_r($l);
// $l[0] -> estado = "completo";
// escribirFichero('tareas.txt', $l);
?>
    </div> -->
</body>
</html>