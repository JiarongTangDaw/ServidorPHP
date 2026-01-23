<?php
    require_once "../conexiones/conectores.php";
    use MongoDB\Driver\Query;
    use MongoDB\Driver\Manager;
    use MongoDB\Driver\BulkWrite;
    use MongoDB\Driver\Exception\Exception;

    $conec = new Conectores();
    $videojuegos = $conec ->procesarMongoDB();
    $bbdd = 'videojuegos_db_jia.plataformas';
    
    $cadena = 'mongodb://jorge:1234@192.168.108.100:27017/videojuegos_db_jia';
    $conexion = new Manager ($cadena);
    $datos = $conexion->executeQuery($bbdd, new Query([], []));
    $datos = $datos->toArray();
    
    // foreach ($datos as $dato) {
    //     echo "<h1>". $dato->nombre."</h1><br>";
    //     foreach ($dato->juegos as $juego) {
    //         echo "<hr><br>";
    //         print_r($juego);
    //         echo "<hr><br>";
    //     }
    // }


?>