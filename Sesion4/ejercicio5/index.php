<?php
    $actual = getcwd();
    $superior = dirname($actual,1);

    $rutaNueva = $superior . "/mi_directorio";
    if(file_exists($rutaNueva) == false){
        mkdir($rutaNueva);
    }

    $archivo = $superior . "/mi_archivo.txt";
    $destino = $rutaNueva ."/mi_archivo_copia.txt";
    copy($archivo,$destino);
?>