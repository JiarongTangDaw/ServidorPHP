<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="ejercicio1.php" id="form" name="form" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre">
        <label for="apellido">Apellidos:</label>
        <input type="text" name="apellido" id="apellido" placeholder="Apellidos">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" placeholder="DNI">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $patronDNI = "/^[0-9]{8}[A-Za-z]$/";

    // Validar campos

    if(empty($nombre)){ // comprobar si está vacío nombre
        echo "El nombre no puede estar vacío.<br>";
    }
    if(empty($apellido)){ // comprobar si está vacío apellido
        echo "El apellido no puede estar vacío.<br>";
    }
    if(empty($dni)){ // comprobar si está vacío dni
        echo "El DNI no puede estar vacío.<br>";
    } elseif(!preg_match($patronDNI, $dni)){ // comprobar formato dni
        echo "El DNI no tiene un formato válido.<br>";
    } else{
        echo "Todos los campos son válidos.<br>";
    }
}
?>