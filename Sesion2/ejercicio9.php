<?php
    $fecha = date('d');

    echo $fecha,'<br>';

    $fechaCompleta = date('l d / F / Y \de, H:i:s A');

    echo $fechaCompleta,'<br>';

    $fechaCompleta = date('d-M-Y, H:i:s A');

    echo $fechaCompleta,'<br>';
    // hora minutos segundos dia mes año
    $timeStamp = mktime(13,41,58,10,9,2025);
    echo $timeStamp,'<br>';

    $timeStamp2 =  $timeStamp + 50000;
    $fecha = date('d-M-Y, H:i:s A',$timeStamp2);

    echo $fecha;
?>