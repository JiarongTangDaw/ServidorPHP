<?php
    
    use MongoDB\Driver\Query;
    use MongoDB\Driver\Manager;
    use MongoDB\Driver\BulkWrite;
    use MongoDB\Driver\Exception\Exception;
;
    $bbdd = 'videojuegos_db_jia.plataformas';
    
    $cadena = 'mongodb://jorge:1234@192.168.108.100:27017/videojuegos_db_jia';
    $conexion = new Manager ($cadena);
    $datos = $conexion->executeQuery($bbdd, new Query([], []));
    $datos = $datos->toArray();
    
?>