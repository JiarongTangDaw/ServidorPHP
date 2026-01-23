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
            
        $salida = $conexion->executeQuery($bbdd, new Query(['nombre'=> $plataforma], []));
        $salida = $salida->toArray();
        $lista = $salida[0] -> juegos;
        $id = count($lista) + 1;
        return $id;
    }

    function agregar($titulo, $anio, $metacritic, $plataforma){
        global $conexion;
        global $bbdd;
            
        $idNuevo = obtenerId($plataforma);

        $newJuego = new BulkWrite();
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
        $erro = '';
        try {
            $resultado = $conexion->executeBulkWrite($bbdd, $newJuego);
            
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
        return $error;
    }

    function eliminar($id,$plataformaOld){
        global $conexion;
        global $bbdd;

        $juego = new BulkWrite();
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

    function modificar($id, $titulo, $anio, $metacritic, $plataformaNew, $plataformaOld){
        global $conexion;
        global $bbdd;
        

        $newJuego = new BulkWrite(); 
        $resultado = $conexion->executeQuery($bbdd, new Query(
            ['nombre' => $plataformaOld, 'juegos.id' => $id],
            ['projection' => ['juegos.$' => 1]]
        ))->toArray();
        $juego = $resultado[0] -> juegos[0];
        $juego -> titulo = $titulo;
        $juego -> anio = $anio;
        $juego -> metacritic = $metacritic;
        if ($plataformaNew != $plataformaOld){
            $idNuevo = obtenerId($plataformaNew);
            $juego -> id = $idNuevo;
        }

        $error = '';
        $error = eliminar($id,$plataformaOld);
        if( $error == ''){
            $newJuego->update(
                [
                    'nombre' => $plataformaNew,
                ],
                [
                    '$push' =>['juegos' => $juego]
                ]
            );
            try {
                $resultado = $conexion->executeBulkWrite($bbdd, $newJuego);
                
            } catch (Exception $e) {
                $erro = $e->getMessage();
            }
        }
        return $error;
    }

?>