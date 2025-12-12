<?php
    $archivo = "../mi_archivo.txt";

    $tiempo = filemtime($archivo);
    $size = filesize($archivo);

    echo "Fecha ultima modificacion: " . date("d F Y H:i:s.",$tiempo) . "<br>";

    echo "Tamaño del archivo: " . $size . " bytes";

?>