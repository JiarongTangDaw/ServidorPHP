<?php
//Incluyo mi fichero de conectores
require_once "./conectores.php";

$conec = new Conectores();

//Me traigo de mi get el conector
$conector = $_GET['conector'] ?? '';

//Inicializo la variable de pintar la tabla
$arrFinalPlataformas=[];
// Llamamos a la función correspondiente
switch ($conector) {
        case 'csv':
                $arrFinalPlataformas = $conec->procesarCSV();
                break;
        case 'xml':
                $arrFinalPlataformas = $conec->procesarXML();
                break;
        case 'json':
                $arrFinalPlataformas = $conec->procesarJSON();
                break;
        case 'mysql':
                $arrFinalPlataformas = $conec->procesarMySQL();
                break;
        default:
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
        <?php
                if (empty($arrFinalPlataformas)) {
                        echo "<h2>No se han encontrado plataformas de videojuegos.</h2>";
                        exit;
                }
                $shtml=$conec->pintarArrayDiv($arrFinalPlataformas);
                print_r($shtml);
        ?>
</body>
</html>
