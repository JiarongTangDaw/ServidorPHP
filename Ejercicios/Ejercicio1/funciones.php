<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenemos la acción del query string (URL)
        $accion = $_GET['action'] ?? '';

        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $direccion = $_POST['direccion'];
        $sexo = $_POST['sexo'];
        $estudios = $_POST['estudios']?? 'off';
        
        if ($estudios == "on") {
            $texto = "Si";
        }else{
            $texto = "No";
        }
        
        echo "<b>Nombre: </b> $nombre <br>";
        echo "<b>Apellidos: </b> $apellidos<br>";
        echo "<b>Direccion: </b> $direccion<br>";
        echo "<b>Sexo: </b> $sexo<br>";
        echo "<b>Grado medio: </b> $texto<br>";
        

    }
?>