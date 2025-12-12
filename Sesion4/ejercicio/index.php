<?php
    // Obtiene la ruta dos niveles por encima del directorio actual de trabajo
    $rutaOrigen = dirname(getcwd(),2);

    // Escanea y obtiene la lista de archivos y directorios de la ruta origen
    $listaOrigen = scandir($rutaOrigen);

    // Imprime el título de la lista
    echo "ServidorPHP <br>";
    
    //  Función recursiva que imprime una lista jerárquica de archivos y directorios
    function pintar($ruta,$lista,$tab = "&nbsp;&nbsp;&nbsp;&nbsp;"){
        // Recorre cada elemento de la lista
        foreach($lista as $fichero){
            // Construye la ruta completa del elemento actual
            $ruta1 = $ruta . '/' . $fichero;

            // Verifica si el elemento es un directorio
            if(is_dir($ruta1)){
                // Excluye los directorios especiales '.' y '..' y '.git' para exploración interna
                if($fichero != '.' && $fichero != ".." && $fichero != ".git"){
                    // Imprime el nombre del directorio en negrita
                    echo "$tab## " . "<b>" . $fichero . "</b><br>";
                    // Llama recursivamente a la función para explorar el contenido del directorio
                    pintar ($ruta1, scandir($ruta1), ($tab . $tab));
                }else if($fichero == ".git"){// Si es el directorio .git, lo muestra pero no explora su contenido
                    echo "$tab## " . "<b>" . $fichero . "</b><br>";
                }
            // Si es un archivo (no directorio)
            }else{
                // Imprime el nombre del archivo con la indentación correspondiente
                echo "$tab## " . $fichero . "<br>";
            }

        }
    }
    // Inicia el proceso de impresión de la estructura de directorios
    pintar($rutaOrigen, $listaOrigen);
?>