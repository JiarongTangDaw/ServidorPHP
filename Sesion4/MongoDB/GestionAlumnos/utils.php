<?php
    require_once __DIR__ . '/Alumno.php';
    require_once __DIR__ . '/Fila.php';

    $config = require_once __DIR__ . '/config.php';
    $arrayFilaAlumnos = procesarMongoDB();
    if(count($arrayFilaAlumnos) <= 0){
        $arrayFilaAlumnos = [];
    }

    use MongoDB\Driver\Query;
    use MongoDB\Driver\Manager;
    use MongoDB\Driver\BulkWrite;

    $bbdd = 'videojuegos_db_jia.filas';
    $cadena = 'mongodb://jorge:1234@192.168.108.100:27017/videojuegos_db_jia';
    $conexion = new Manager ($cadena);
    $datos = $conexion->executeQuery($bbdd, new Query([], []));
    $datos = $datos->toArray();

    function procesarMongoDB()
    {
        //Esta funcion me coge el xml de mi fichero de configuracion y me lo convierte en un array
        global $config;
        $mongo = $config['database']['mongodb'];
        $cadena = 'mongodb://'. $mongo['usuario']. ':' . $mongo['password'] . '@'. $mongo['host'] . ':' . $mongo['puerto'] . '/' . $mongo['database'];
        $arr_salida = [];
        try {
            $conexion = new Manager ($cadena);
            $datos = $conexion->executeQuery('videojuegos_db_jia.filas', new Query([], []));
            $datos = $datos->toArray();
            foreach($datos as $key => $filaAlumnos){
                $numFila = $filaAlumnos->numero;
                $arrayAlumnos = [];
                foreach($filaAlumnos->alumnos as $alumno){
                    $nombre = $alumno->nombre;
                    $apellidos = $alumno->apellidos;
                    $sexo = $alumno->sexo;
                    $esProfeSexy = $alumno->es_profe_sexy;
                    $newAlumno = new Alumno();
                    $newAlumno->setNombre($nombre);
                    $newAlumno->setApellidos($apellidos);
                    $newAlumno->setSexo($sexo);
                    $newAlumno->setEsProfeSexy($esProfeSexy);
                    array_push($arrayAlumnos, $newAlumno); 
                }
                $fila = new Fila();
                $fila->setNumero($numFila);
                $fila->setAlumnos($arrayAlumnos);
                array_push($arr_salida, $fila);
            }
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
        return $arr_salida;
    }
?>