<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $mensaje = $_GET['msg'];
        $mensaje = strip_tags($mensaje);
        $mensaje = htmlspecialchars($mensaje);
        echo "<h1>$mensaje</h1>";
    ?>
</body>
</html>