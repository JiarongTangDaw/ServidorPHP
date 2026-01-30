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

        $titulo = $_POST['titulo']??'';
        $anio = (int) $_POST['anio']?? 0;
        $metacritic = (int) $_POST['metacritic']?? '';
        $plataformaOld = $_POST['plataformaOld'] ?? '';
        $plataformaNew = $_POST['plataformaNew'] ?? '';
        $id = (int) $_POST['idVideojuego'] ?? 0;


        // Llamamos a la función correspondiente
        switch ($accion) {
            case 'modificar':
                $error = modificar($id, $titulo, $anio, $metacritic, $plataformaNew, $plataformaOld);
                if($error != ''){
                    header("Location: index.php?error=$error");
                }else{
                    header("Location: index.php?mensaje=videojuego modificado correctamente");
                }
                break;
            case 'eliminar':
                eliminar($id,$plataformaOld);
                header("Location: index.php?mensaje=videojuego eliminado correctamente");
                break;
            case 'add':
                $error =agregar($titulo, $anio, $metacritic, $plataformaNew);
                if($error != ''){
                    header("Location: index.php?error=$error");
                }else{
                    header("Location: index.php?mensaje=videojuego agregado correctamente");
                }
                break;
            default:
        }
    }

    function obtenerId($plataforma){
        global $conexion;
        global $bbdd;
        
        // Obtener la lista de juegos de la plataforma
        $salida = $conexion->executeQuery($bbdd, new Query(['nombre'=> $plataforma], []));
        $salida = $salida->toArray(); // Convertir a array
        $lista = $salida[0] -> juegos; // Acceder a la lista de juegos
        $id = count($lista) + 1; // Generar un nuevo ID (simplemente el tamaño de la lista + 1)
        return $id;
    }

    // Función para agregar un nuevo videojuego
    function agregar($titulo, $anio, $metacritic, $plataforma){
        global $conexion;
        global $bbdd;
            
        // Generar un nuevo ID para el videojuego
        $idNuevo = obtenerId($plataforma);
        
        // Crear el nuevo videojuego
        $newJuego = new BulkWrite();
        // Agregar el nuevo videojuego a la plataforma correspondiente
        $newJuego->update(
            ['nombre' => $plataforma],
            [
                '$push' =>[
                    'juegos' => [
                        'id' => $idNuevo,
                        'titulo' => $titulo,
                        'anio' => $anio,
                        'metacritic' => $metacritic,
                        'portada' => ''
                    ]
                ]
            ]
        );
        // Ejecutar la operación de escritura
        $erro = '';
        try { // Intentar ejecutar la operación
            $resultado = $conexion->executeBulkWrite($bbdd, $newJuego);
            
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
        return $error;
    }
 // Función para eliminar un videojuego
    function eliminar($id,$plataformaOld){
        global $conexion;
        global $bbdd;
        
        // Crear la operación de eliminación
        $juego = new BulkWrite();
        // Eliminar el videojuego de la plataforma correspondiente
        $juego -> update(['nombre' => $plataformaOld],[
            '$pull' =>[ 'juegos' => ['id' => $id]]
        ]);

        $erro = '';
        try {
            $resultado = $conexion->executeBulkWrite($bbdd, $juego);
            
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
        return $error;
    }

    // Función para modificar un videojuego
    function modificar($id, $titulo, $anio, $metacritic, $plataformaNew, $plataformaOld){
        global $conexion;
        global $bbdd;
        
        // Obtener el videojuego existente
        $newJuego = new BulkWrite(); 
        // Obtener el videojuego existente
        $resultado = $conexion->executeQuery($bbdd, new Query(
            ['nombre' => $plataformaOld, 'juegos.id' => $id],
            ['projection' => ['juegos.$' => 1]] // Proyección para obtener solo el juego coincidente
        ))->toArray();
        $juego = $resultado[0] -> juegos[0]; // Acceder al juego encontrado
        $juego -> titulo = $titulo;
        $juego -> anio = $anio;
        $juego -> metacritic = $metacritic;
        // Si la plataforma ha cambiado, actualizar el ID del juego
        if ($plataformaNew != $plataformaOld){
            $idNuevo = obtenerId($plataformaNew);
            $juego -> id = $idNuevo;
        }

        $error = '';
        // Eliminar el juego de la plataforma antigua
        $error = eliminar($id,$plataformaOld);
        if( $error == ''){ // Si no hubo error al eliminar
            // Agregar el juego a la nueva plataforma
            $newJuego->update(
                [
                    'nombre' => $plataformaNew,
                ],
                [
                    '$push' =>['juegos' => $juego]
                ]
            );
            try { // Intentar ejecutar la operación
                $resultado = $conexion->executeBulkWrite($bbdd, $newJuego);
                
            } catch (Exception $e) {
                $erro = $e->getMessage();
            }
        }
        return $error;
    }

?>