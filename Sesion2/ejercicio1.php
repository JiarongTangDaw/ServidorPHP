<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo PHP básico</title>
</head>
<body>
    <h1>Mi primera pagina con PHP</h1>
    <p>Esto es HTML normal.</p>
    <?php
        // Esto es un comentario PHP; no se envía al navegador
        echo "<p>¡Hola desde PHP! Este párrafo ha sido generado por el servidor.</p>";
        echo "<p>La fecha de hoy en el servidor es: " . date('d/m/Y'). "</p>";
    ?>
    <p>Más HTML normal despued del bloque PHP</p>
</body>
</html>
<!-- CODIGO HTML DENTRO DE UN ARCHIVO PHP -->