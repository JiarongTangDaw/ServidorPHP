<?php
    require_once "./conexion.php";
    global $videojuegos;

    $error = $_GET['error'] ?? '';
    if($error != ''){
        echo "<script>alert('$error');</script>";
    }
    $mensaje = $_GET['mensaje'] ?? '';
    if($mensaje != ''){
        echo "<script>alert('$mensaje');</script>";
    }
    global $datos;
    $plataformas = [];
    foreach ($datos as $plat) {
        if (!in_array($plat->nombre, $plataformas)) {
            $plataformas[] = $plat->nombre;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videojuegos</title>
    <link rel="stylesheet" href="style.css">
    <script src="./funciones.js" defer></script>
</head>
<body>
    <form action="funciones.php" id="formulario" name="formulario" method="post">
        <!-- los hidden son para guardar los valores que vamos ha pasar a php con el post -->
        <input type="hidden" name="plataformaNew" id="plataformaNew">
        <input type="hidden" name="plataformaOld" id="plataformaOld">


        <div id="principal">
            
            <!-- Fila en donde se encontrara los campos a rellenar para un nuevo comic -->
            <div id="nuevo">
                <h2>Nueva Plataforma</h2>
                <label for="plataforma0">Plataforma</label> 

                <input type="text" id="plataforma0" value="">
                
                <!-- boton para añadir el comic nuevo -->
                <div class="botones">
                    <input type="button" id="btAdd" onclick="agregar();" value="NUEVO">
                </div>
            </div><!-- cabecera para la tabla de lista de comics -->
            
        </div>
        <div class="plataformas">
        <h2>Plataformas Disponibles</h2>
        <div id="cabecera">
            <p>Plataforma</p>
            <p>Botones</p>
        </div>
        <div id="listaPlataformas">
            <?php 
                foreach($plataformas as $plat){
            ?>                  
                <input type="text" id="<?= $plat ?>" value="<?= $plat ?>">
                <div class="botones">
                    <input type="button" id="btElim" onclick="eliminar('<?= $plat ?>');" value="ELIMINAR">
                    <input type="button" id="btMod" onclick="modificar('<?= $plat ?>');" value="MODIFICAR">
                </div>
            <?php
                }
            ?>
        </div>
            
    </div>
    </form>
</body>
</html>