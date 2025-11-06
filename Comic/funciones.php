<?php 

// Verificamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenemos la acción del query string
    $accion = $_GET['action'] ?? '';

    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $estado = $_POST['estado'];
    $ubicacion = $_POST['ubicacion'];
    $prestado = $_POST['prestado'];
    $id = $_POST['id'];

    // Llamamos a la función correspondiente
    switch ($accion) {
        case 'modificar':
            modificarComic($id, $titulo, $autor, $estado, $ubicacion,$prestado);
            volver();
            break;
        case 'eliminar':
            eliminarComic($id);
            volver();
            break;
        case 'add':
            agregarComic($titulo, $autor, $estado, $ubicacion,$prestado);
            volver();
            break;
        default:
    }
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
        return false;
    }

    // Decodificar el JSON a un array asociativo
    $datos = json_decode($contenido);

    // Verificar errores de decodificación
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Error al decodificar JSON: ' . json_last_error_msg());
        return false;
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
    
    // comprobar que el archivo json sea leido correctamente o que exista
    if($comics === null || $comics === false){
        return false;
    }

    // filtrar por titulo
    if($titulo != ''){
        $comics =  array_filter($comics, function($comic) use ($titulo){
            return str_contains(strtolower($comic -> titulo), strtolower($titulo)) == true;
        });
    }
    // filtar por autor
    if($autor != ''){
        $comics = array_filter($comics, function($comic) use ($autor){
            return str_contains(strtolower($comic -> autor), strtolower($autor)) == true;
        });
    }
    //filtrar por estado
    if($estado != ''){
        $comics = array_filter($comics, function ($comic) use ($estado) {
            return $comic -> estado == $estado;
        });
    }
    //filtrar por ubicacion
    if ($ubicacion != ''){
        $comics = array_filter($comics, function ($comic) use ($ubicacion) {
            return $comic -> ubicacion == $ubicacion;
        });
    }
    //filtrar por prestado
    if ($prestado != ''){
        $prestadoB = $prestado == 'si'? true : false;
        $comics = array_filter($comics, function ($comic) use ($prestadoB) {
            return $comic -> prestado == $prestadoB;
        });
    }
    
    return $comics;
}

function agregarComic($titulo,$autor,$estado,$ubicacion,$prestado) {
    //Cargo el json  en memoria
    $comics = cargarJSON('comics.json');
    if ($comics === null) {
        $comics = [];
    }elseif($comics === false){
        return false;
    }
    // Genero el id nuevo para el comic
    $id = generarIdComic($comics);
    $prestadoB = $prestado == 'si' ? true: false;

    // Nuevo comic que queremos añadir
    $newComic = (object)['id' => $id, 'titulo' => $titulo, 'autor' => $autor, 'estado' => $estado, 'ubicacion' => $ubicacion, 'prestado' => $prestadoB];

    // Añadimos el nueva comic al array
    $comics[] = $newComic;

    //Guardo el json
    guardarJSON('comics.json', $comics);
    return true;
}

function eliminarComic($id) {
    //Cargo el json  en memoria
    $comics = cargarJSON('comics.json');
    if ($comics === null || $comics === false) {
        return false;
    }

    foreach ($comics as $index => $comic) {
        if ($comic->id == $id) {
            unset($comics[$index]); // Elimina el elemento
            break; // Opcional: salir del bucle si solo hay uno
        }
    }

    // Reindexar el array si quieres índices consecutivos
    $comics = array_values($comics);

    //Guardo el json
    guardarJSON('comics.json', $comics);
    return true;
}

function modificarComic($id,$newTitulo,$newAutor,$newEstado,$newUbicacion,$newPrestado) {
    // Cargo el JSON en memoria
    $comics = cargarJSON('comics.json');
    if ($comics === null || $comics === false) {
        return false;
    }

    // Recorremos por referencia para modificar el objeto directamente
    foreach ($comics as &$comic) {
        if ($comic -> id == $id) {
            $comic -> titulo = $newTitulo;  // cambia el titulo de comic
            $comic -> autor = $newAutor;    //cambiar el autor de comic
            $comic -> estado = $newEstado; // cambia el estado
            $comic -> ubicacion = $newUbicacion; // cambiar ubicacion
            $prestadoB = $newPrestado == 'si'? true : false;
            $comic -> prestado = $prestadoB; // cambiar valor prestado
            break; // ya no hace falta seguir buscando
        }
    }
    unset($comic); // buena práctica al usar referencias (&)

    // Guardar el JSON actualizado
    guardarJSON('comics.json', $comics);

    return true;
}

function generarIdComic($comics): int
{
    $id = 0;
    //Saco su elemento máximo
    $maximo = obtenerElementoMaximo($comics, 'id');
    //Recorro el array para ver cual es el primer id libre a partir del primero que tenemos
    for ($i = 1; $i <= $maximo; $i++) {
        $resultado = array_filter($comics, function ($comic) use ($i) {
            return $comic->id == $i;
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

?>