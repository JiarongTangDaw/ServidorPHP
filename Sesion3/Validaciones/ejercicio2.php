<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="ejercicio2.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre">
        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario" placeholder="Escribe tu comentario aquí..."></textarea>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $comentario = $_POST['comentario'] ?? '';

    // Validar nombre
    if (empty($nombre)){// comprobar si está vacío nombre
        echo "El nombre no puede estar vacío.<br>";
    } else{
        if(empty($comentario)){// Validar comentario
            echo "El comentario no puede estar vacío.<br>";
        } else{// mostrar nombre y comentario de forma segura
            $comentarioSeguro = strip_tags($comentario);
            $comentarioSeguro = htmlspecialchars($comentarioSeguro);
            $nombreSeguro = strip_tags($nombre);
            $nombreSeguro = htmlspecialchars($nombreSeguro);
            echo "Nombre: $nombreSeguro <br> Comentario: $comentarioSeguro.<br>";
        }
    }
}