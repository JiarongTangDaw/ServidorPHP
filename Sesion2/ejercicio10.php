<?php
    $hoy = date_create('now');
    
    echo 'hoy: ', $hoy->format('Y-m-d H:i:s'),'<br>';

    $futura = date_create('2025-12-31');
    $diferencia = date_diff($hoy,$futura);

    echo 'dias hasta el 31/12/2025: ', $diferencia->format('%a dias'),'<br>';
    echo 'Desglosado: ', $diferencia->format('%y años %m meses %d dias %h horas %i minutos %s segundos'),'<br>';
?>