<?php 

    require_once "./conexion.php";
    use MongoDB\Driver\Query;
    use MongoDB\Driver\Manager;
    use MongoDB\Driver\BulkWrite;
    use MongoDB\Driver\Exception\Exception;

    // Verificamos si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenemos la acción del query string
        $accion = $_GET['action'] ?? '';

        
        $plataformaNew = $_POST['plataformaNew'] ?? '';
        $plataformaOld = $_POST['plataformaOld'] ?? '';


        // Llamamos a la función correspondiente
        switch ($accion) {
            case 'add':
                $error =agregar($plataformaNew);
                if($error != ''){
                    header("Location: index.php?error=$error");
                }else{
                    header("Location: index.php?mensaje=plataforma agregada correctamente");
                }
                break;
            default:
        }
    }


    // Función para agregar un nuevo videojuego
    function agregar($plataforma){
        global $conexion;
        global $bbdd;
        
        // Crear el nuevo videojuego
        $newPlatform = new BulkWrite();
        // Agregar el nuevo videojuego a la plataforma correspondiente
        $newPlatform->insert(
            ['nombre' => $plataforma, 'juegos' => []]
        );
        // Ejecutar la operación de escritura
        $erro = '';
        try { // Intentar ejecutar la operación
            $resultado = $conexion->executeBulkWrite($bbdd, $newPlatform);
            
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
        return $error;
    }


?>