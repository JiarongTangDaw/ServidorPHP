<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reciproco Matematico</title>
</head>
<body>
    <form action="index.php" method="post">
        <label for="num1">Numero: </label>
        <input type="text" name="num" id="num1">
        <input type="submit" value="Enviar"><br><br>
    </form>
</body>
</html>

<?php

    function dividir(int $num){
        $mensaje = "<b>Reciproco Matematico de $num: </b>";
        try {
            $division = 1 / $num;
            $mensaje .= "$division <br>";
            echo $mensaje;
        } catch (DivisionByZeroError $e) {
            $mensaje .= "Error: No se puede dividir por cero";
            echo $mensaje;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST['num']??'';
        if($num1 === ''){
            echo "No puede haber campos vacios";
        }else{
            dividir($num1);            
        }
    }

?>