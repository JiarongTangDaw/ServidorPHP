<?php
    $fichero = 'juegos.json';
    if (file_exists($fichero)) {
        $json = file_get_contents($fichero);
        $datos = json_decode($json, true);
        foreach($datos['plataformas'] as $plataforma){
            echo "<h2>" . $plataforma['nombre'] . "</h2>";
            echo "<ul>";
            foreach($plataforma['juegos'] as $juego){
                echo "<li> <img src='" . $juego['portada'] . "' alt='" . $juego['titulo'] . "'> <br> Titulo: " . $juego['titulo'] . "<br> Año: " . $juego['anio'] . "<br> Metacritic: " . $juego['metacritic'] . "</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "El fichero no existe";
    }

?>