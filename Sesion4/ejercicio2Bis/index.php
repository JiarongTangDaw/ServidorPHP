<?php
    require_once './Videojuegos.php';
    $csv = 'juegos.csv';

    $existe = file_exists($csv);

    if($existe){
        $f = fopen($csv, 'r');
        $contenido = file($csv);
        $contenido = array_slice($contenido,1);
        $listaVJ = [];
        foreach ($contenido as $linea) {
            $datoJuego = explode(',',$linea);
            $juego = new VideoJuego($datoJuego);
            $consola = $juego->getConsola();
            if(!isset($listaVJ[$consola])){
                $listaVJ[$juego->getConsola()] = [];
            }
            $listaVJ[$consola][] = $juego;
        }
        
        foreach($listaVJ as $key => $value){
            
        }
    }else{
        echo 'No existe el archivo';
    }
    
    
?>