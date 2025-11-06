<?php

// Verificamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenemos la acción del query string
    $accion = $_GET['action'] ?? '';

    $tarea = $_POST['tarea'];
    $estado = $_POST['estado'];
    $id = $_POST['id'];

    // Llamamos a la función correspondiente
    switch ($accion) {
        case 'guardar':
            modificarTarea($tarea, $estado, $id);
            volver();
            break;
        case 'eliminar':
            eliminarTarea($id);
            volver();
            break;
        case 'anadir':
            anadirTarea($tarea, $estado);
            volver();
            break;

        default:
    }
}

function volver()
{
    //Volvemos a la página que ha hecho el submit
    header('Location: index.php?ok=1');
    exit();
}

function anadirTarea($tarea, $estado)
{
    //Cargo el json  en memoria
    $tareas = cargarJSON('tareas.json');
    if ($tareas === null) {
        return false;
    }
    // Genero el id nuevo para la tarea
    $id = generarIdTarea($tareas);

    // Nueva tarea que queremos añadir
    $nuevaTarea = (object)['id' => $id, 'tarea' => $tarea, 'estado' => $estado];

    // Añadimos la nueva tarea al array
    $tareas[] = $nuevaTarea;

    //Guardo el json
    guardarJSON('tareas.json', $tareas);
    return true;
}

function modificarTarea($nuevaTarea, $nuevoEstado, $id)
{
    // Cargo el JSON en memoria
    $tareas = cargarJSON('tareas.json');
    if ($tareas === null) {
        return false;
    }

    // Recorremos por referencia para modificar el objeto directamente
    foreach ($tareas as &$tarea) {
        if ($tarea->id == $id) {
            $tarea->tarea = $nuevaTarea;  // cambia el texto de la tarea
            $tarea->estado = $nuevoEstado; // cambia el estado
            break; // ya no hace falta seguir buscando
        }
    }
    unset($tarea); // buena práctica al usar referencias (&)

    // Guardar el JSON actualizado
    guardarJSON('tareas.json', $tareas);

    return true;
}

function eliminarTarea($id)
{
    //Cargo el json  en memoria
    $tareas = cargarJSON('tareas.json');
    if ($tareas === null) {
        return false;
    }

    foreach ($tareas as $index => $tarea) {
        if ($tarea->id == $id) {
            unset($tareas[$index]); // Elimina el elemento
            break; // Opcional: salir del bucle si solo hay uno
        }
    }

    // Reindexar el array si quieres índices consecutivos
    $tareas = array_values($tareas);

    //Guardo el json
    guardarJSON('tareas.json', $tareas);
    return true;
}

function generarIdTarea($tareas): int
{
    $id = 0;
    //Saco su elemento máximo
    $maximo = obtenerElementoMaximo($tareas, 'id');
    //Recorro el array para ver cual es el primer id libre a partir del primero que tenemos
    for ($i = 1; $i <= $maximo; $i++) {
        $resultado = array_filter($tareas, function ($tarea) use ($i) {
            return $tarea->id == $i;
        });
        if (empty($resultado)) {
            $id = $i;
            break;
        }
    }

    //Si no tengo id el máximo es el siguiente
    if ($id == 0) {
        $id = $maximo + 1;
    }

    return $id;
}

function obtenerElementoMaximo($datos, $propiedad)
{
    if (empty($datos)) {
        return null;
    }

    // Usamos array_reduce para encontrar el máximo
    $maximo = array_reduce($datos, function ($a, $b) use ($propiedad) {
        if ($a === null) {
            return $b;
        }
        return ($b->$propiedad > $a->$propiedad) ? $b : $a;
    });

    return $maximo->id;
}

function listarTareas($tarea, $estado)
{
    $tareas = cargarJSON('tareas.json');

    if ($tareas === null) {
        return false;
    }

    $tareas = array_filter($tareas, function ($otarea) use ($tarea, $estado) {

        if ($tarea != '' && $estado != '') {
            return str_contains(strtolower($otarea->tarea), strtolower($tarea)) == true && $otarea->estado == $estado;
        } elseif ($tarea != '') {
            return str_contains(strtolower($otarea->tarea), strtolower($tarea)) == true;
        } elseif ($estado != '') {
            return $otarea->estado == $estado;
        } else {
            return $otarea;
        }
    });

    if ($tareas === null) {
        return false;
    }
    return $tareas;
}


/**
 * Carga un fichero JSON y lo convierte a un array asociativo.
 *
 * @param string $ruta Ruta del archivo JSON.
 * @return array|null Devuelve el contenido del JSON como array o null si falla.
 */
function cargarJSON($ruta)
{
    // Verificar si el archivo existe
    if (!file_exists($ruta)) {
        error_log("Error: El archivo '$ruta' no existe.");
        return null;
    }

    // Leer el contenido del archivo
    $contenido = file_get_contents($ruta);
    if ($contenido === false) {
        error_log("Error: No se pudo leer el archivo '$ruta'.");
        return null;
    }

    // Decodificar el JSON a un array asociativo
    $datos = json_decode($contenido);

    // Verificar errores de decodificación
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Error al decodificar JSON: ' . json_last_error_msg());
        return null;
    }

    return $datos;
}

/**
 * Guarda un array como JSON en un archivo.
 */
function guardarJSON($ruta, $datos)
{
    $json = json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents($ruta, $json) === false) {
        error_log("Error: No se pudo escribir en el archivo '$ruta'.");
        return false;
    }
    return true;
}
