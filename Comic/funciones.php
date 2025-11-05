<?php  
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

function volver()
{
    //Volvemos a la página que ha hecho el submit
    header('Location: index.php?ok=1');
    exit();
}

function listarComic($titulo,$autor,$estado,$ubicacion,$prestado) {
    $comics = cargarJSON('comics.json');

    if($titulo != ''){
        $comics =  array_filter($comics, function($comic) use ($titulo){
            return str_contains(strtolower($comic -> titulo), strtolower($titulo)) == true;
        });
    }

    if($autor != ''){
        $comics = array_filter($comics, function($comic) use ($autor){
            return str_contains(strtolower($comic -> autor), strtolower($autor)) == true;
        });
    }

    if($estado != ''){
        $comics = array_filter($comics, function ($comic) use ($estado) {
            return $comic -> estado == $estado;
        });
    }

    if ($ubicacion != ''){
        $comics = array_filter($comics, function ($comic) use ($ubicacion) {
            return $comic -> ubicacion == $ubicacion;
        });
    }

    if ($prestado != ''){
        $comics = array_filter($comics, function ($comic) use ($prestado) {
            return $comic -> prestado == $prestado;
        });
    }

    if($comics === null){
        return false;
    }

    return $comics;
}

function agregarComic() {
    
}

function eliminarComic() {
    
}

function modificarComic() {
    
}

?>