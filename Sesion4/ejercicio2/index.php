<?php
    // Obtiene la ruta dos niveles por encima del directorio actual de trabajo
    $rutaOrigen = dirname(getcwd(),2);

    // Escanea y obtiene la lista de archivos y directorios de la ruta origen
    $listaOrigen = scandir($rutaOrigen);

    // Imprime el título de la lista
    echo "ServidorPHP <br>";
    
    //  Función recursiva que imprime una lista jerárquica de archivos y directorios
    function pintar($ruta,$lista,$archivo,$tab = "&nbsp;&nbsp;&nbsp;&nbsp;",$tabText = "\t"){
        // Recorre cada elemento de la lista
        foreach($lista as $fichero){
            // Construye la ruta completa del elemento actual
            $rutaF = $ruta . '/' . $fichero;

            $linea = '';

            // Verifica si el elemento es un directorio
            if(is_dir($rutaF)){
                // Excluye los directorios especiales '.' y '..' y '.git' para exploración interna
                if($fichero != '.' && $fichero != ".." && $fichero != ".git"){
                    // Imprime el nombre del directorio en negrita
                    
                    $linea = "$tabText## " . $fichero ;
                    echo "$tab## " . "<b>" . $fichero . "</b><br>";
                    fwrite($archivo,$linea . PHP_EOL);
                    // Llama recursivamente a la función para explorar el contenido del directorio
                    pintar ($rutaF, scandir($rutaF),$archivo, ($tab . $tab), ($tabText . $tabText));
                }else if($fichero == ".git"){// Si es el directorio .git, lo muestra pero no explora su contenido
                    $linea = "$tabText## " . $fichero ;
                    echo "$tab## " . "<b>" . $fichero . "</b><br>";
                    fwrite($archivo,$linea . PHP_EOL);
                }
            // Si es un archivo (no directorio)
            }else{
                // Imprime el nombre del archivo con la indentación correspondiente
                $linea = "$tabText## " . $fichero ;
                echo "$tab## " . $fichero . "<br>";
                fwrite($archivo,$linea . PHP_EOL);
            }

        }
    }

    if (!file_exists('directorio.txt')) {
        $f = fopen('directorio.txt','w'); // se crea el archivo vacio para escritura
    } else {
        $f = fopen('directorio.txt','w'); // se abre el archivo para escritura (añadir)
    }
    fwrite($f,"ServidorPHP" . PHP_EOL);
    
    // Inicia el proceso de impresión de la estructura de directorios
    pintar($rutaOrigen, $listaOrigen,$f);

    fclose($f);
?>