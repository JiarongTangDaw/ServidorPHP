<?php
    use MongoDB\Driver\Query;
    use MongoDB\Driver\Manager;
    use MongoDB\Driver\BulkWrite;

    $conexion = new Manager ('mongodb://jorge:1234@192.168.108.100:27017/videojuegos_db');

    $plataformas = $conexion->executeQuery('videojuegos_db.plataformas', new Query([], []));
    $plataformas = $plataformas->toArray();
    var_dump($plataformas);
    echo "<h1 style='color: blue;'>Plataformas y sus juegos</h1>";
/*
    //insertar una nueva plataforma
    $newPlatafora = new BulkWrite();
    $newPlatafora->insert([
        'nombre' => 'NEOGEO',
        'juegos' => []
    ]);
    $conexion->executeBulkWrite('videojuegos_db.plataformas', $newPlatafora);*/
    echo "<br>";
    //*mostrar
    foreach($plataformas as $plataforma){
        echo "Plataforma: " . $plataforma->nombre . "<br>";
        echo "Juegos: <br>";
        foreach($plataforma->juegos as $juego){
            echo "- " . $juego->titulo . "<br>";
        }
        echo "<br>";
    }
?>