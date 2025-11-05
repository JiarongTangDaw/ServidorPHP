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
</head>
<body>
    <form action="funciones.php" id="formulario" name="formulario" method="post">

        <div id="principal">

            <input type="hidden" name="titulo" id="titulo">
            <input type="hidden" name="autor" id="autor">
            <input type="hidden" name="estado" id="estado">
            <input type="hidden" name="ubicacion" id="ubicacion">
            <input type="hidden" name="prestado" id="prestado">
            <input type="hidden" name="id" id="id">
                        
            <div id="filtro">
                <h3 id="tituloFiltro">FILTRO</h3>
                <div id="valorFiltro">
                    <input type="text" name="filTitulo" id="filTitulo" placeholder="Escribe titulo...">
                    <input type="text" name="filAutor" id="filAutor" placeholder="Escribe autor ...">
                    <div id="cajaEstado">
                        <label for="filEstado">Estado</label>
                        <select name="filEstado" id="filEstado">
                            <option value=""></option>
                            <option value="pendiente">Pendiente</option>
                            <option value="leyendo">Leyendo</option>
                            <option value="leido">Leído</option>
                        </select>
                    </div>
                    <div id="cajaUbicacion">
                        <label for="filUbicacion">Ubicacion</label>
                        <select name="filUbicacion" id="filUbicacion">
                            <option value=""></option>
                            <option value="estanteria1">Estanteria 1</option>
                            <option value="estanteria2">Estanteria 2</option>
                            <option value="mueble">Mueble</option>
                        </select>
                    </div>
                    <div id="cajaPrestado">
                        <label for="filPrestado">Prestado</label>
                        <select name="filPrestado" id="filPrestado">
                            <option value=""></option>
                            <option value="si">Si</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id="cabecera">                
                <p>Titulo</p>
                <p>Autor</p>
                <p>Ubicacion</p>
                <p>Estado</p>
                <p>Prestado</p>
                <p>Botones</p>
            </div>
            <div id="listado">
                <!-- Cambiar esto por un foreach para cada comic -->
                <input type="text" id="titulo" value="">
                <input type="text" id="autor" value="" >
                <select id="estado" require>
                    <option value="pendiente">Pendiente</option>
                    <option value="leyendo">Leyendo</option>
                    <option value="leido">Leido</option>
                </select>
                <select id="ubicacion">
                    <option value="estanteria1">Estanteria 1</option>
                    <option value="estanteria2">Estanteria 2</option>
                    <option value="mueble">Mueble</option>
                </select>
                <select name="prestado" id="prestado">
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select>
                <div class="botones">
                    <input type="button" value="ADD">
                    <input type="button" value="MOD">
                    <input type="button" value="DEL">
                </div>
            </div>
        </div>
    </form>
</body>
</html>