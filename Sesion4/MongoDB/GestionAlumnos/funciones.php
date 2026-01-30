<?php
    require_once __DIR__ . '/alumno.php';
    require_once __DIR__ . '/fila.php';

    require_once __DIR__ . '/utils.php';

    global $arrayFilaAlumnos;

    use MongoDB\Driver\Query;
    use MongoDB\Driver\Manager;
    use MongoDB\Driver\BulkWrite;
    use MongoDB\Driver\Exception\Exception;

    // Verificamos si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenemos la acción del query string
        $accion = $_GET['action'] ?? '';

        // Obtener los datos del formulario
        $nombre = $_POST['nombre']??'';
        $apellidosOld = $_POST['apellidosOld']??'';
        $apellidosNew = $_POST['apellidosNew']??'';
        $numFilaOld = (int)$_POST['numFilaOld'] ?? '';
        $numFilaNew = (int)$_POST['numFilaNew'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $esProfeSexy = $_POST['esProfeSexy'] ?? '';

        $esProfeSexy = ($esProfeSexy == 0 || $esProfeSexy == '' ? false : true);


        // Llamamos a la función correspondiente
        switch ($accion) {
            case 'importar': //importar los datos
                global $arrayFilaAlumnos;
                $error = '';
                if(empty($arrayFilaAlumnos)){ // Solo importar si no hay datos en la base de datos
                    $error =importar();
                }else{
                    $error = "Ya hay datos en la base de datos, no se pueden importar más";
                }
                // Redirigir con mensaje de error o éxito
                if($error != ''){
                    header("Location: index.php?error=$error"); 
                }else{
                    header("Location: index.php?mensaje=Datos importados correctamente");
                }

                break;
            case 'modificar'://modificar un alumno
                $error = modificar($nombre, $apellidosOld, $apellidosNew, $numFilaOld, $numFilaNew, $sexo, $esProfeSexy);
                if($error != ''){
                    header("Location: index.php?error=$error");
                }else{
                    header("Location: index.php?mensaje=alumno modificado correctamente");
                }
                break;
            case 'eliminar'://eliminar un alumno
                $error = eliminar($apellidosOld,$numFilaOld);
                if($error != ''){
                    header("Location: index.php?error=$error");
                }else{
                    header("Location: index.php?mensaje=alumno eliminado correctamente");
                }
                break;
            case 'add': //agregar un alumno
                $error =agregar($nombre, $apellidosNew, $numFilaNew, $sexo, $esProfeSexy);
                if($error != ''){
                    header("Location: index.php?error=$error");
                }else{
                    header("Location: index.php?mensaje=alumno agregado correctamente");
                }
                break;
            default:
        }
    }


    // Función para agregar un nuevo alumno
    function agregar($nombre, $apellidosNew, $numFilaNew, $sexo, $esProfeSexy){
        global $conexion;
        global $bbdd;
         
        
        // Crear el nuevo alumno
        $newAlumno = new BulkWrite();
        // Agregar la nueva fila a la base de datos
        $newAlumno->update(
            ['numero' => $numFilaNew],
            [
                '$push' =>[ //añadimos un nuevo alumno a la fila
                    'alumnos' => [
                        'nombre' => $nombre,
                        'apellidos' => $apellidosNew,
                        'sexo' => $sexo,
                        'es_profe_sexy' => $esProfeSexy
                    ]
                ]
            ]
        );
        // Ejecutar la operación de escritura
        $error = '';
        try { // Intentar ejecutar la operación
            $resultado = $conexion->executeBulkWrite($bbdd, $newAlumno);
            
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        return $error;
    }

    // Función para eliminar un alumno
    function eliminar($apellidosOld,$numFilaOld){
        global $conexion;
        global $bbdd;
        
        // Crear la operación de eliminación
        $alumno = new BulkWrite();
        // Eliminar el alumno de la fila correspondiente
        $alumno -> update(
            ['numero' => $numFilaOld],
            [ '$pull' =>[ 
                'alumnos' => ['apellidos' => $apellidosOld]
                ]
            ]
        );

        $error = '';
        try {
            $resultado = $conexion->executeBulkWrite($bbdd, $alumno);
            
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        return $error;
    }

    // Función para modificar un alumno
    function modificar($nombre, $apellidosOld, $apellidosNew, $numFilaOld, $numFilaNew, $sexo, $esProfeSexy){
        global $conexion;
        global $bbdd;

        echo $sexo;
        
        // Obtener el alumno existente
        $newFila = new BulkWrite(); 
        // Obtener el alumno existente
        $resultado = $conexion->executeQuery($bbdd, new Query(
            ['numero' => $numFilaOld, 'alumnos.apellidos' => $apellidosOld],
            ['projection' => ['alumnos.$' => 1]] // Proyección para obtener solo el alumno coincidente
        ))->toArray();
        $alumno = $resultado[0] -> alumnos[0]; // Acceder al alumno encontrado
        $alumno -> nombre = $nombre;
        $alumno -> apellidos = $apellidosNew;
        $alumno -> sexo = $sexo;
        $alumno -> es_profe_sexy = $esProfeSexy;
        
        $error = '';
        // Eliminar el alumno de la fila antigua
        $error = eliminar($apellidosOld,$numFilaOld);
        if( $error == ''){ // Si no hubo error al eliminar
            // Agregar el alumno a la nueva fila
            $newFila->update(
                [
                    'numero' => $numFilaNew,
                ],
                [
                    '$push' =>['alumnos' => $alumno]
                ]
            );
            try { // Intentar ejecutar la operación
                $resultado = $conexion->executeBulkWrite($bbdd, $newFila);
                
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        return $error;
    }

    function importar(){
        global $conexion;
        global $bbdd;
        global $arrayFilaAlumnos;
        
        procesarCsv();
        procesarXML();
        procesarJSON();
        $error = '';
        foreach ($arrayFilaAlumnos as $item) {
            // Crear la nueva fila
            $newFila = new BulkWrite();
            // Agregar la nueva fila a la base de datos
            $newFila->insert(
                ['numero' => $item->getNumero(), 'alumnos' => $item->getAlumnos()]
            );
            // Ejecutar la operación de escritura
            try { // Intentar ejecutar la operación
                $resultado = $conexion->executeBulkWrite($bbdd, $newFila);
                
            } catch (Exception $e) {
                $error .= $e->getMessage() . "\n";
            }
        }

        return $error;
    }


    function procesarCsv(){
        //Esta funcion me coge el csv de mi fichero de configuracion y me lo convierte en un array
        global $config;
        global $arrayFilaAlumnos;

        $csv = $config['database']['csv'];
        $fichero = __DIR__ . "\\" . $csv;
        $arr_salida = [];
        if (file_exists($fichero)) {
            //Abro el cursor del fichero
            $f = fopen($fichero, "r");

            //Me lo convierto cada linea en un array con el metodo fgetcsv y lo voy añadiendo a mi array final

            //Recordar que el curso se posiciona en la primera linea y siempre hay que leerla
            $array = fgetcsv($f);
            array_push($arr_salida, $array);
            while (!feof($f)) {
                //El bucle me va línea a línea mientras no sea el caracter final de fichero
                $array = fgetcsv($f,0,';');
                array_push($arr_salida, $array);
            }

            //Cierro el fichero para evitar errores de memoria
            fclose($f);
        }

        $arr_salida = array_slice($arr_salida, 1); //Elimino la primera fila que son los encabezados
        
        foreach($arr_salida as $fila){
            $key = $fila[2];
            $newFila = new Fila();
            $newFila->setNumero($key);
            $encontrado = array_filter($arrayFilaAlumnos, function($item) use ($key) {
                return $item->getNumero() == $key;
            });
            if(empty($encontrado)){
                $arrayFilaAlumnos[] = $newFila;
            }
            $esProfeSexi = ($fila[4] == 0 ? false : true);
            $newAlumno = new Alumno();
            $newAlumno->setNombre($fila[0]);
            $newAlumno->setApellidos($fila[1]);
            $newAlumno->setSexo($fila[3]);
            $newAlumno->setEsProfeSexy($esProfeSexi);
            
            foreach($arrayFilaAlumnos as $item){
                if($item->getNumero() == $key){
                    $alumnosFila = $item->getAlumnos();
                    $alumnosFila[] = $newAlumno;
                    $item->setAlumnos($alumnosFila);
                }
            }
        }
    }


    function procesarXML(){
        //Esta funcion me coge el xml de mi fichero de configuracion y me lo convierte en un array
        global $config;
        global $arrayFilaAlumnos;

        $xml = $config['database']['xml'];
        $fichero = __DIR__ . "\\". $xml;
        $arr_salida = [];
        if (file_exists($fichero)) {
            $xml = simplexml_load_file($fichero);
            foreach ($xml as $child) {
                $arr_salida[] = $child;
            }
        }
        foreach($arr_salida as $fila){
            $fila = (array)$fila;
            $key = $fila['fila'];
            
            $newFila = new Fila();
            $newFila->setNumero($key);
            $encontrado = array_filter($arrayFilaAlumnos, function($item) use ($key) {
                return $item->getNumero() == $key;
            });
            if(empty($encontrado)){
                $arrayFilaAlumnos[] = $newFila;
            }
            $esProfeSexi = ($fila['es_profe_sexi'] == 0 ? false : true);

            $newAlumno = new Alumno();
            $newAlumno->setNombre($fila['nombre']);
            $newAlumno->setApellidos($fila['apellidos']);
            $newAlumno->setSexo($fila['sexo']);
            $newAlumno->setEsProfeSexy($esProfeSexi);
            
            foreach($arrayFilaAlumnos as $item){
                if($item->getNumero() == $key){
                    $alumnosFila = $item->getAlumnos();
                    $alumnosFila[] = $newAlumno;
                    $item->setAlumnos($alumnosFila);
                }
            }
        }
    }

    function procesarJSON(){
        //Esta funcion me coge el json de mi fichero de configuracion y me lo convierte en un array
        global $config;
        global $arrayFilaAlumnos;

        $json = $config['database']['json'];
        $fichero = __DIR__ . "\\". $json;
        $arr_salida = [];
        if (file_exists($fichero)) {
            $json = file_get_contents($fichero);
            $datos = json_decode($json, true);
            foreach ($datos as $item) {
                $arr_salida[] = $item;
            }
        }
         foreach($arr_salida as $fila){
            $key = $fila['fila'];
            
            $newFila = new Fila();
            $newFila->setNumero($key);
            $encontrado = array_filter($arrayFilaAlumnos, function($item) use ($key) {
                return $item->getNumero() == $key;
            });
            if(empty($encontrado)){
                $arrayFilaAlumnos[] = $newFila;
            }
            $esProfeSexi = ($fila['es_profe_sexi'] == 0 ? false : true);

            $newAlumno = new Alumno();
            $newAlumno->setNombre($fila['nombre']);
            $newAlumno->setApellidos($fila['apellidos']);
            $newAlumno->setSexo($fila['sexo']);
            $newAlumno->setEsProfeSexy($esProfeSexi);
            
            foreach($arrayFilaAlumnos as $item){
                if($item->getNumero() == $key){
                    $alumnosFila = $item->getAlumnos();
                    $alumnosFila[] = $newAlumno;
                    $item->setAlumnos($alumnosFila);
                }
            }
        }
    }
    
?>