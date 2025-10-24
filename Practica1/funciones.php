<?php



function leerFichero($archivo)
{
    $tareas = [];

    if (file_exists($archivo)) {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!empty($lineas)) {
            foreach ($lineas as $linea) {
                $partes = explode(',', $linea);

                if (count($partes) >= 2) {
                    $tarea = trim(str_replace('tarea:', '', $partes[0]));
                    $estado = trim(str_replace('estado:', '', $partes[1]));

                    $tareas [] = (object)[
                        'tarea' => $tarea,
                        'estado' => $estado
                    ];
                }
            }
            $tareas = addId($tareas);
        }
    }

    return $tareas;
};

function escribirFichero($archivo, $tareas)
{
    $contenido = '';

    foreach ($tareas as $tarea) {
        $contenido .= "tarea: {$tarea -> tarea}, estado: {$tarea -> estado} \n";
    }

    file_put_contents($archivo, $contenido);

};

function addId(&$tareas)
{
    $contador = 1;
    foreach ($tareas as $tarea) {
        $tarea -> id = $contador;
        $contador++;
    }
}

function modificarID(&$tareas)
{
    foreach ($tareas as $num => $tarea) {
        $tarea -> id = $num + 1;
    }

    return $tareas;
}

function visualizarTarea(&$tareas)
{
    $tabla = "<table>";
    $tabla .= "<thead>";
    $tabla .= "<tr>";
    $tabla .= "<th>ID</th>";
    $tabla .= "<th>TAREA</th>";
    $tabla .= "<th>ESTADO</th>";
    $tabla .= "<!-- <th>BOTONES</th> -->";
    $tabla .= "</tr>";
    $tabla .= "</thead>";
    $tabla .= "<tbody>";

    foreach ($tareas as $num => $tarea) {

        $idTarea = $tarea -> id;
        $nomTarea = $tarea -> tarea;
        $estadoTarea = $tarea -> estado;

        $tabla .= "<tr>";
        $tabla .= "<td>$idTarea</td>";
        $tabla .= "<td>$nomTarea</td>";
        $tabla .= "<td>$estadoTarea</td>";
        $tabla .= "<!-- <td id=\"elimEdit\">";
        $tabla .= "<button type=\"submit\" class=\"delete\" id=\"btElim\">";
        $tabla .= "Eliminar Tarea";
        $tabla .= " </button>";
        $tabla .= "<button type=\"submit\" class=\"edit\" id=\"btEditar\">";
        $tabla .= "Editar Tarea";
        $tabla .= "</button>";
        $tabla .= "</td> -->";
        $tabla .= "</tr>";
        echo $num;
    }

    $tabla .= "</tbody>";
    $tabla .= "</table>";

    return $tabla;

};

function addTarea(&$tareas, $tarea, $estado)
{

};

function eliminarTarea(&$tareas, $idTarea)
{
    unset($tareas[$idTarea - 1]);
    $tareas = modificarID($tareas);

    return $tareas;

};

function validarTarea()
{

};

function editarTarea()
{

};



function filtrar()
{

}
