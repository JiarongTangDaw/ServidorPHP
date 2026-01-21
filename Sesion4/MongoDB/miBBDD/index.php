<?php
    use MongoDB\Driver\Query;
    use MongoDB\Driver\Manager;
    use MongoDB\Driver\BulkWrite;
    use MongoDB\BSON\Regex;

    $conexion = new Manager ('mongodb://jorge:1234@192.168.108.100:27017/videojuegos_db_jia');

    $plataformas = $conexion->executeQuery('videojuegos_db_jia.plataformas', new Query([], []));
    $plataformas = $plataformas->toArray();

    /*
    //insertar una nueva plataforma
    $newPlatafora = new BulkWrite();
    $newPlatafora->insert([
        'nombre' => 'NEOGEO',
        'juegos' => []
    ]);
    $conexion->executeBulkWrite('videojuegos_db_jia.plataformas', $newPlatafora);
    */

    //*mostrar
    echo "<h1 style='color: blue;'>Plataformas y sus juegos</h1>";
    foreach($plataformas as $plataforma){
        echo "Plataforma: " . $plataforma->nombre . "<br>";
        echo "Juegos: <br>";
        foreach($plataforma->juegos as $juego){
            echo "- " . $juego->titulo . "<br>";
        }
        echo "<hr>";
    }
    //*ordenar
    echo "<h1 style='color: blue;'>Plataformas ordenadas por nombre</h1>";
    $salida = $conexion->executeQuery('videojuegos_db_jia.plataformas', new Query([], ['sort' => ['nombre' => 1]])); // si pones -1 ordena descendente
    foreach($salida as $plataforma){
        echo "Plataforma: " . $plataforma->nombre . "<br>";
        echo "Juegos: <br>";
        foreach($plataforma->juegos as $juego){
            echo "- " . $juego->titulo . "<br>";
        }
        echo "<hr>";
    }
    //*filtrar por nombre que empiece por p
    echo "<h1 style='color: blue;'>Plataformas que empiezan por 'p'</h1>";  
    $salida = $conexion->executeQuery('videojuegos_db_jia.plataformas', new Query(
        ['nombre' => new Regex('^p','i')],// añado la 'i' para que no distinga mayusculas y minusculas
        ['sort' => ['nombre' => 1]]
    ));
    foreach($salida as $plataforma){
        echo "Plataforma: " . $plataforma->nombre . "<br>";
        echo "Juegos: <br>";
        foreach($plataforma->juegos as $juego){
            echo "- " . $juego->titulo . "<br>";
        }
        echo "<hr>";
    }

    //*filtrado por nombre plataforma y ordenado por titulo de juego
    echo "<h1 style='color: blue;'>Filtrado por nombre plataforma y ordenado por titulo de juego</h1>";
    $salida = $conexion->executeQuery('videojuegos_db_jia.plataformas', new Query(
        ['nombre' => ['$eq' => 'PC']],
        ['sort' => ['titulo' => 1]]
    ));

    foreach($salida as $plataforma){
        echo "Plataforma: " . $plataforma->nombre . "<br>";
        echo "Juegos: <br>";
        foreach($plataforma->juegos as $juego){
            echo "- " . $juego->titulo . "<br>";
        }
        echo "<hr>";
    }
?>