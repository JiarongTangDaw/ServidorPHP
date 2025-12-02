<?php
    set_error_handler("manejoErrores");
    set_exception_handler("manejaExcepciones");

    function manejoErrores($nivel, $mensaje, $fichero, $linea) {
        $mensaje = "Fecha: " . date("H:i d-m-Y") .
               " | Mensaje: " . $mensaje .
               " | Archivo: " . $fichero .
               " | Línea: " . $linea .
               " | Usuario: " . get_current_user() .
               " | IP: " . $_SERVER['REMOTE_ADDR'] . PHP_EOL;

    // Registra el error en un archivo log personalizado
    error_log($mensaje, 3, "C:/Users/Alumno.DESKTOP-DI5KTUG/Desktop/ServidorPHP/Sesion3/BBDD/errores/error_Usuario.txt");
    }

    function manejaExcepciones(Throwable $ex) {
         $mensaje = "Fecha: " . date("H:i d-m-Y") .
               " | Mensaje: " . $ex->getMessage() .
               " | Archivo: " . $ex->getFile() .
               " | Línea: " . $ex->getLine() .
               " | Usuario: " . get_current_user() .
               " | IP: " . $_SERVER['REMOTE_ADDR'] . PHP_EOL;

    // Guardar en el log (siempre recomendable)
    error_log($mensaje, 3, "C:/Users/Alumno.DESKTOP-DI5KTUG/Desktop/ServidorPHP/Sesion3/BBDD/errores/exception_Usuario.txt");

    // Mostrar un mensaje controlado al usuario
    echo "<b>Ocurrió un error:</b> " . htmlspecialchars($ex->getMessage());
    }
?>