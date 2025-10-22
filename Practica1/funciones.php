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
            // $tareas = addId($tareas);
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

function modificarID($tareas)
{
    foreach ($tareas as $num => $tarea) {
        $tarea['id'] = $num + 1;
    }

    return $tareas;
}

function visualizarTarea($tareas)
{

};

function addTarea($array, $tarea)
{

};

function eliminarTarea($tareas, $idTarea)
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
