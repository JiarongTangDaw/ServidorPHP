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
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM plataformas");
    $stmt->execute();
    $plataformas = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <input type="hidden" name="titulo" id="titulo">
        <input type="hidden" name="anio" id="anio">
        <input type="hidden" name="plataforma" id="plataforma">
        <input type="hidden" name="metacritic" id="metacritic">
        <input type="hidden" name="idVideojuego" id="idVideojuego">


        <div id="principal">
            
            <!-- Fila en donde se encontrara los campos a rellenar para un nuevo comic -->
            <div id="nuevo">
                <h2>Nuevo Videojuego</h2>
                <label for="titulo0">Titulo</label>
                <input type="text" id="titulo0" value="">
                <label for="plataforma0">Plataforma</label> 
                <select id="plataforma0">
                    <option value=''></option>
                    <?php foreach($plataformas as $plataforma): ?>
                        <option value="<?= $plataforma['nombre'] ?>"><?= $plataforma['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="anio0">Año</label>
                <input type="number" id="anio0" min="1900" value="">
                <label for="metacritic0">Metacritic</label>
                <input type="text" id="metacritic0" value="">
                
                <!-- boton para añadir el comic nuevo -->
                <div class="botones">
                    <input type="button" id="btAdd" onclick="agregar();" value="NUEVO">
                </div>
            </div><!-- cabecera para la tabla de lista de comics -->
            <div id="cabecera">                
                <p>Plataforma</p>
                <p>Título</p>
                <p>Año</p>
                <p>Metacritic</p>
                <p>Botones</p>
            </div>
            <!-- listado de los comics que tenemos -->
            <div id="listado">
                <?php
                    foreach($videojuegos as $plataforma){
                        $arrayJuegos = $plataforma -> getvideojuegos();
                        $plataformaNombre = $plataforma -> getplataforma();
                        foreach($arrayJuegos as $juego){
                ?>
                <select name="plataforma<?=$juego -> video_juego_id?>" id="plataforma<?=$juego -> video_juego_id?>">
                <?php foreach($plataformas as $plataforma): ?>
                    <option value="<?= $plataforma['nombre'] ?>" <?= $plataforma['nombre'] == $plataformaNombre ? 'selected' : '' ?>><?= $plataforma['nombre']?></option>
                <?php endforeach; ?>
                </select>
                    <input type="text" name="titulo<?=$juego -> video_juego_id?>" id="titulo<?=$juego -> video_juego_id?>" value="<?= $juego -> titulo ?>">
                    <input type="number" name="anio<?=$juego -> video_juego_id?>" id="anio<?=$juego -> video_juego_id?>" value="<?= $juego -> anio ?>">
                    <input type="text" name="metacritic<?=$juego -> video_juego_id?>" id="metacritic<?=$juego -> video_juego_id?>" value="<?= $juego -> metacritic ?>">
                <!-- campo con botones de eliminar y modificar para modificar y eliminar comic, por el cual se le pasa el id del comic al que seleccionamos -->
                <div class="botones">
                    <input type="button" value="MOD" onclick= "modificar('<?=$juego -> video_juego_id?>');">
                    <input type="button" value="DEL" onclick= "eliminar('<?=$juego -> video_juego_id?>');">
                </div>
                <?php
                        }}
                ?>
            </div>
        </div>
    </form>
</body>
</html>