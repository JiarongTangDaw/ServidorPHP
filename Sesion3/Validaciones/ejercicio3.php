<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="ejercicio3.php" method="post">
        <label for="correo">Correo electronico: </label>
        <input type="text" id="correo" name="correo" placeholder="Correo electronico">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'] ?? '';
    //pattern para validar correo
    $patrongCorreo = "/^[a-zA-Z0-9]{1}[a-zA-Z0-9._%+-]+@(?!.*\.[a-z]{1,10}\.[a-z]{2,4}$)[a-zA-Z0-9]{1}[a-zA-Z0-9-]*[a-zA-Z0-9]{1}(\.[a-zA-Z0-9]{1}[a-zA-Z0-9-]*[a-zA-Z0-9]{1})*\.[a-zA-Z]{2,}$/i";

    // Validar correo
    if (empty($correo)){
        echo "El correo no puede estar vacío.<br>";
    } else{
        if(!preg_match($patrongCorreo, $correo)){// comprobar formato
            echo "El correo no tiene un formato válido.<br>";
        } else{
            echo "El correo es válido.<br>";
        }
    }
}
?>