<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encontrar fichero</title>
</head>
<body>
    <form action="index.php" method="post">
        <label for="archivo">Nombre archivo:</label>
        <input type="text" name="archivo" id="archivo">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

<?php

// 2. Función que abre el archivo ejercicio 3
function abrirArchivo($nombreArchivo) {
    if (!file_exists($nombreArchivo)) {
        throw new Exception("El archivo $nombreArchivo no fue encontrado");
    }

    $archivo = fopen($nombreArchivo, "r");
    echo "Archivo '$nombreArchivo' abierto correctamente <br>";
    return $archivo;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomArchivo = $_POST['archivo']??'';
        if($nomArchivo === ''){
            echo "No puede haber campos vacios";
        }else{
            try {
                $arc = abrirArchivo($nomArchivo);
                echo $arc;
                fclose($arc);
            } catch (Exception $e) {

                echo "Error: ". $e ->getMessage();
            }        
        }
    }
?>