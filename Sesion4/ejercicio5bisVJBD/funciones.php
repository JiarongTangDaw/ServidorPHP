<?php 

    require_once "./conexion.php";

    // Verificamos si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenemos la acción del query string
        $accion = $_GET['action'] ?? '';

        $titulo = $_POST['titulo']??'';
        $anio = $_POST['anio']?? 0;
        $metacritic = $_POST['metacritic']?? '';
        $plataforma = $_POST['plataforma'] ?? '';
        $id = $_POST['idVideojuego'] ?? 0;

        // Llamamos a la función correspondiente
        switch ($accion) {
            case 'modificar':
                $error = modificar($id, $titulo, $anio, $metacritic, $plataforma);
                if($error != ''){
                    header("Location: index.php?error=$error");
                }else{
                    header("Location: index.php?mensaje=videojuego modificado correctamente");
                }
                break;
            case 'eliminar':
                eliminar($id);
                header("Location: index.php?mensaje=videojuego eliminado correctamente");
                break;
            case 'add':
                $error =agregar($titulo, $anio, $metacritic, $plataforma);
                if($error != ''){
                    header("Location: index.php?error=$error");
                }else{
                    header("Location: index.php?mensaje=videojuego agregado correctamente");
                }
                break;
            default:
        }
    }

    function buscarIdPlataforma($plataformaNombre){
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM plataformas WHERE nombre = :plataformaNombre");
        $stmt->bindParam(':plataformaNombre', $plataformaNombre);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : -1;
    }

    function agregar($titulo,$anio,$metacritic,$plataforma){
        global $pdo;

        $plataforma_id = buscarIdPlataforma($plataforma);
        $error = '';
        if($plataforma_id == -1){
            $error = "La plataforma no existe. No se puede agregar el videojuego.";
        }else{
            $stmt = $pdo->prepare("INSERT INTO juegos (titulo, anio, metacritic, plataforma_id) VALUES (:titulo, :anio, :metacritic, :plataforma_id)");
            // $stmt->bindParam(':titulo', $titulo);
            // $stmt->bindParam(':anio', $anio);
            // $stmt->bindParam(':metacritic', $metacritic);
            // $stmt->bindParam(':plataforma_id', $plataforma_id);
            $stmt->execute([
                ':titulo' => $titulo,
                ':anio' => $anio,
                ':metacritic' => $metacritic,
                ':plataforma_id' => $plataforma_id
            ]);
        }
        return $error;
        
    }
    
    function modificar($id, $titulo, $anio, $metacritic, $plataforma){
        global $pdo;

        $plataforma_id = buscarIdPlataforma($plataforma);
        $error = '';
        if($plataforma_id == -1){
            $error = "La plataforma no existe. No se puede modificar el videojuego.";
        }else{
            $stmt = $pdo->prepare("UPDATE juegos SET titulo = :titulo, anio = :anio, metacritic = :metacritic, plataforma_id = :plataforma_id WHERE id = :id");
            //* definicion de parametros cuando se necesita espeficicar tipo de datos
            // $stmt->bindParam(':titulo', $titulo);
            // $stmt->bindParam(':anio', $anio);
            // $stmt->bindParam(':metacritic', $metacritic);
            // $stmt->bindParam(':plataforma_id', $plataforma_id);
            // $stmt->bindParam(':id', $id);
            //*definicion de parametros cuando empiezas 
            $stmt->execute([
                'titulo' => $titulo,
                'anio' => $anio,
                'metacritic' => $metacritic,
                'plataforma_id' => $plataforma_id,
                'id' => $id
            ]);
        }
        return $error;
    }

    function eliminar($id){
        global $pdo;

        $stmt = $pdo->prepare("DELETE FROM juegos WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

?>