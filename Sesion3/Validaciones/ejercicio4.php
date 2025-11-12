<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="ejercicio4.php" method="post">
        <label>INTERESES</label><br>
        <input type="checkbox" id="deportes" name="intereses[]" value="deportes">
        <label for="deportes">Deportes</label><br> 
        <input type="checkbox" id="musica" name="intereses[]" value="musica">
        <label for="musica">Música</label><br>
        <input type="checkbox" id="tecnologia" name="intereses[]" value="tecnologia">
        <label for="tecnologia">Tecnología</label><br>
        <input type="checkbox" id="arte" name="intereses[]" value="arte">
        <label for="arte">Arte</label><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $intereses = $_POST['intereses'] ?? [];

    // Validar intereses
    if (empty($intereses)){ // comprobar si está vacío
        echo "Debe seleccionar al menos un interés.<br>";
    } else{// mostrar intereses seleccionados
        echo "Intereses seleccionados:<br>";
        foreach ($intereses as $interes) {
            echo "$interes <br>";
        }
    }
}
?>