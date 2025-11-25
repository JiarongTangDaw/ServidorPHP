<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suma/Division</title>
</head>
<body>
    <form action="index.php" method="post">
        <label for="num1">Numero 1: </label>
        <input type="text" name="num1" id="num1">
        <label for="num2">Numero 2:</label>
        <input type="text" name="num2" id="num2">
        <input type="submit" value="Enviar"><br><br>
    </form>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST['num1']??'';
        $num2 = $_POST['num2']??'';
        if($num1 === '' || $num2 === ''){
            echo "No puede haber campos vacios";
        }else{
            $num1 = (int) $num1;
            $num2 = (int) $num2;
            echo "<b>Numero 1:</b> $num1<br>";
            echo "<b>Numero 2:</b> $num2<br>";
            echo "<b>Suma:</b> $num1 + $num2 = ". ($num1 + $num2) . "<br>";
            $mDivision = "<b>Division: </b>";
            try {
                $division = $num1 / $num2;
                $mDivision .= "$num1 / $num2 = $division <br>";
                echo $mDivision;
            } catch (DivisionByZeroError $e) {
                $mDivision .= "Error: No se puede dividir por cero";
                echo $mDivision;
            }
        }
    }

?>