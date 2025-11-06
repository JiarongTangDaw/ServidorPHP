<?php
    require_once 'funciones.php';

    $filTitulo = '';
    $filAutor = '';
    $filEstado = '';
    $filUbicacion = '';
    $filPrestado = '';

    // sacamos los valores de los filtro si se ha definido
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
        <!-- los hidden son para guardar los valores que vamos ha pasar a php con el post -->
        <input type="hidden" name="titulo" id="titulo">
        <input type="hidden" name="autor" id="autor">
        <input type="hidden" name="estado" id="estado">
        <input type="hidden" name="ubicacion" id="ubicacion">
        <input type="hidden" name="prestado" id="prestado">
        <input type="hidden" name="id" id="id">

        <div id="principal">
            <!-- Este contendedor va ha contener los campos por el que vamos ha filtrar la lista de comics -->
            <div id="filtro">
                <h3 id="tituloFiltro">FILTRO</h3>
                <div id="valorFiltro"> 
                    <!-- campo de filtro de titulo -->
                    <input type="text" name="filTitulo" id="filTitulo" placeholder="Escribe titulo..." value ="<?= $filTitulo ?>" onchange="filtrar()">
                    <!-- campo de filtro de autor -->
                    <input type="text" name="filAutor" id="filAutor" placeholder="Escribe autor ..." value ="<?= $filAutor ?>" onchange="filtrar()">
                    <!-- campo de filtro de estado que va ha ser un select -->
                    <div id="cajaEstado">
                        <label for="filEstado">Estado</label>
                        <select name="filEstado" id="filEstado" onchange="filtrar()">
                            <option value="" ></option>
                            <option value="pendiente"  <?= $filEstado === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="leyendo" <?= $filEstado === 'leyendo' ? 'selected' : '' ?> >Leyendo</option>
                            <option value="leido" <?= $filEstado === 'leido' ? 'selected' : '' ?> >Leído</option>
                        </select>
                    </div>
                    <!-- Campo de filtro de ubicacion que es un select -->
                    <div id="cajaUbicacion">
                        <label for="filUbicacion">Ubicacion</label>
                        <select name="filUbicacion" id="filUbicacion" onchange="filtrar()">
                            <option value=""></option>
                            <option value="estanteria1" <?= $filUbicacion === 'estanteria1' ? 'selected' : '' ?> >Estanteria 1</option>
                            <option value="estanteria2" <?= $filUbicacion === 'estanteria2' ? 'selected' : '' ?> >Estanteria 2</option>
                            <option value="mueble" <?= $filUbicacion === 'mueble' ? 'selected' : '' ?> >Mueble</option>
                        </select>
                    </div>
                    <!-- campo de filtro de prestado que es un select -->
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
            <!-- cabecera para la tabla de lista de comics -->
            <div id="cabecera">                
                <p>Titulo</p>
                <p>Autor</p>
                <p>Estado</p>
                <p>Ubicacion</p>
                <p>Prestado</p>
                <p>Botones</p>
            </div>
            <!-- Fila en donde se encontrara los campos a rellenar para un nuevo comic -->
            <div id="nuevo">
                <!-- Campo para el titulo -->
                <input type="text" id="titulo0" value=""> 
                <!-- campo para el autor -->
                <input type="text" id="autor0" value="">
                <!-- select para los estados -->
                <select id="estado0">
                    <option value=""></option>
                    <option value="pendiente">Pendiente</option>
                    <option value="leyendo">Leyendo</option>
                    <option value="leido">Leido</option>
                </select>
                <!-- select para la ubicacion del comic -->
                <select id="ubicacion0">
                    <option value=""></option>
                    <option value="estanteria1">Estanteria 1</option>
                    <option value="estanteria2">Estanteria 2</option>
                    <option value="mueble">Mueble</option>
                </select>
                <!-- select para prestado del comic -->
                <select id="prestado0">
                    <option value=""></option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select>
                <!-- boton para añadir el comic nuevo -->
                <div class="botones">
                    <input type="button" id="btAdd" onclick="agregar();" value="NUEVO">
                </div>
            </div>
            <!-- listado de los comics que tenemos -->
            <div id="listado">
                <?php
                // comprobamos que si tenemos un comics en nuestra base de datos (comics.json)
                    if($comics === false){ // no hay comics en la base de datos
                        echo "<h2> No hay Comics aun, añade uno </h2>";
                    }elseif($comics == []){ // no hay comics con filtro
                        echo "<h2> No hay Comics con este filtro </h2>";
                    }else{ // si hay comics
                        // foreach para recorrer el array de comics
                        foreach ($comics as $comic) {
                ?>
                <!-- campo para el titulo el valor es el que esta registrado en el array en el campo titulo, y el id es titulo + id que esta en el array -->
                <input type="text" id="titulo<?= $comic -> id ?>" value="<?= $comic -> titulo ?>">
                <!-- campo para el autor el valor es el que esta registrado en el array en el campo autor, y el id es autor + id que esta en el array -->
                <input type="text" id="autor<?= $comic -> id ?>" value="<?= $comic -> autor ?>" >
                <!-- campo para el estado el valor es el que esta registrado en el array en el campo estado, y el id es estado + id que esta en el array -->
                <select id="estado<?= $comic -> id ?>" require>
                    <option value="pendiente" <?= $comic -> estado === 'pendiente'? 'selected' : '' ?> >Pendiente</option>
                    <option value="leyendo" <?= $comic -> estado === 'leyendo'? 'selected' : '' ?> >Leyendo</option>
                    <option value="leido" <?= $comic -> estado === 'leido'? 'selected' : '' ?> >Leido</option>
                </select>
                <!-- campo para el ubicacion el valor es el que esta registrado en el array en el campo ubicacion, y el id es ubicacion + id que esta en el array -->
                <select id="ubicacion<?= $comic -> id ?>">
                    <option value="estanteria1" <?= $comic -> ubicacion === 'estanteria1'? 'selected' : '' ?> >Estanteria 1</option>
                    <option value="estanteria2" <?= $comic -> ubicacion === 'estanteria2'? 'selected' : '' ?> >Estanteria 2</option>
                    <option value="mueble" <?= $comic -> ubicacion === 'mueble'? 'selected' : '' ?> >Mueble</option>
                </select>
                <!-- campo para el prestado el valor es el que esta registrado en el array en el campo prestado, y el id es prestado + id que esta en el array -->
                <select name="prestado<?= $comic -> id ?>" id="prestado<?= $comic -> id ?>">
                    <option value="si" <?= $comic -> prestado === true? 'selected' : '' ?> >Si</option>
                    <option value="no" <?= $comic -> prestado === false? 'selected' : '' ?> >No</option>
                </select>
                <!-- campo con botones de eliminar y modificar para modificar y eliminar comic, por el cual se le pasa el id del comic al que seleccionamos -->
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