<?php
    require_once 'funciones.php';

    $filTitulo = '';
    $filAutor = '';
    $filEstado = '';
    $filUbicacion = '';
    $filPrestado = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $filTitulo = $_POST['titulo'];
        $filAutor = $_POST['autor'];
        $filEstado = $_POST['estado'];
        $filUbicacion = $_POST['ubicacion'];
        $filPrestado = $_POST['prestado'];
    }

    $comics = [];
    $comics = listarComic($filTitulo, $filAutor, $filEstado, $filUbicacion, $filPrestado);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comic</title>
    <link rel="stylesheet" href="style.css">
    <script src="./funciones.js" defer></script>
</head>
<body>
    <form action="funciones.php" id="formulario" name="formulario" method="post">

        <input type="hidden" name="titulo" id="titulo">
        <input type="hidden" name="autor" id="autor">
        <input type="hidden" name="estado" id="estado">
        <input type="hidden" name="ubicacion" id="ubicacion">
        <input type="hidden" name="prestado" id="prestado">
        <input type="hidden" name="id" id="id">

        <div id="principal">
      
            <div id="filtro">
                <h3 id="tituloFiltro">FILTRO</h3>
                <div id="valorFiltro">
                    <input type="text" name="filTitulo" id="filTitulo" placeholder="Escribe titulo..." value ="<?= $filTitulo ?>" onchange="filtrar()">
                    <input type="text" name="filAutor" id="filAutor" placeholder="Escribe autor ..." value ="<?= $filAutor ?>" onchange="filtrar()">
                    <div id="cajaEstado">
                        <label for="filEstado">Estado</label>
                        <select name="filEstado" id="filEstado" onchange="filtrar()">
                            <option value="" ></option>
                            <option value="pendiente"  <?= $filEstado === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="leyendo" <?= $filEstado === 'leyendo' ? 'selected' : '' ?> >Leyendo</option>
                            <option value="leido" <?= $filEstado === 'leido' ? 'selected' : '' ?> >Leído</option>
                        </select>
                    </div>
                    <div id="cajaUbicacion">
                        <label for="filUbicacion">Ubicacion</label>
                        <select name="filUbicacion" id="filUbicacion" onchange="filtrar()">
                            <option value=""></option>
                            <option value="estanteria1" <?= $filUbicacion === 'estanteria1' ? 'selected' : '' ?> >Estanteria 1</option>
                            <option value="estanteria2" <?= $filUbicacion === 'estanteria2' ? 'selected' : '' ?> >Estanteria 2</option>
                            <option value="mueble" <?= $filUbicacion === 'mueble' ? 'selected' : '' ?> >Mueble</option>
                        </select>
                    </div>
                    <div id="cajaPrestado">
                        <label for="filPrestado">Prestado</label>
                        <select name="filPrestado" id="filPrestado" onchange="filtrar()">
                            <option value=""></option>
                            <option value="si" <?= $filPrestado === 'si' ? 'selected' : '' ?> >Si</option>
                            <option value="no" <?= $filPrestado === 'no' ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id="cabecera">                
                <p>Titulo</p>
                <p>Autor</p>
                <p>Estado</p>
                <p>Ubicacion</p>
                <p>Prestado</p>
                <p>Botones</p>
            </div>
            <div id="nuevo">
                <input type="text" id="titulo0" value="">
                <input type="text" id="autor0" value="">
                <select id="estado0">
                    <option value=""></option>
                    <option value="pendiente">Pendiente</option>
                    <option value="leyendo">Leyendo</option>
                    <option value="leido">Leido</option>
                </select>
                <select id="ubicacion0">
                    <option value=""></option>
                    <option value="estanteria1">Estanteria 1</option>
                    <option value="estanteria2">Estanteria 2</option>
                    <option value="mueble">Mueble</option>
                </select>
                <select id="prestado0">
                    <option value=""></option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select>
                <div class="botones">
                    <input type="button" id="btAdd" onclick="agregar();" value="NUEVO">
                </div>
            </div>
            <div id="listado">
                <?php
                    if($comics == false){
                        echo "<h2> No hay Comics aun, añade uno </h2>";
                    }else{
                        foreach ($comics as $comic) {
                ?>
                <input type="text" id="titulo<?= $comic -> id ?>" value="<?= $comic -> titulo ?>">
                <input type="text" id="autor<?= $comic -> id ?>" value="<?= $comic -> autor ?>" >
                <select id="estado<?= $comic -> id ?>" require>
                    <option value="pendiente" <?= $comic -> estado === 'pendiente'? 'selected' : '' ?> >Pendiente</option>
                    <option value="leyendo" <?= $comic -> estado === 'leyendo'? 'selected' : '' ?> >Leyendo</option>
                    <option value="leido" <?= $comic -> estado === 'leido'? 'selected' : '' ?> >Leido</option>
                </select>
                <select id="ubicacion<?= $comic -> id ?>">
                    <option value="estanteria1" <?= $comic -> ubicacion === 'estanteria1'? 'selected' : '' ?> >Estanteria 1</option>
                    <option value="estanteria2" <?= $comic -> ubicacion === 'estanteria2'? 'selected' : '' ?> >Estanteria 2</option>
                    <option value="mueble" <?= $comic -> ubicacion === 'mueble'? 'selected' : '' ?> >Mueble</option>
                </select>
                <select name="prestado<?= $comic -> id ?>" id="prestado<?= $comic -> id ?>">
                    <option value="si" <?= $comic -> prestado === true? 'selected' : '' ?> >Si</option>
                    <option value="no" <?= $comic -> prestado === false? 'selected' : '' ?> >No</option>
                </select>
                <div class="botones">
                    <input type="button" value="MOD" onclick= "modificar('<?= $comic -> id ?>');">
                    <input type="button" value="DEL" onclick= "eliminar('<?= $comic -> id ?>');">
                </div>
                <?php
                        };};
                ?>
            </div>
        </div>
    </form>
</body>
</html>