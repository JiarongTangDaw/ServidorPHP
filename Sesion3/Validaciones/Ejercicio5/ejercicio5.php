<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="ejercicio5.php" method="post">
        <label for="resultado">Cuanto es 10 + 10 :</label>
        <input type="text" id="resultado" name="resultado" placeholder="Respuesta">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resultado = $_POST['resultado'] ?? '';

    // Validar resultado
    if (empty($resultado)){ // comprobar si está vacío
        $mensaje = "El resultado no puede estar vacío.<br>";
        // el urlencode es para que los espacios y caracteres especiales no den problemas en la URL
        header("Location:error.php?msg=" . urlencode($mensaje));
    } elseif (!is_numeric($resultado)) {// comprobar si es un numero
        $mensaje = "El resultado tiene que ser un numero.<br>";
        header("Location:error.php?msg=" . urlencode($mensaje));
    }else if((int)$resultado !== 20){ // comprobar si es correcto
        $mensaje = "El resultado es incorrecto.<br>";
        header("Location:error.php?msg=" . urlencode($mensaje));
    } else{
        $mensaje = "El resultado es correcto.<br>";
        header("Location:exito.php?msg=" . urlencode($mensaje));
    }
}
?>
