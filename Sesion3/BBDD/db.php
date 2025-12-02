<?php

    require_once './error.php';

    $ruta = "C:/Users/Alumno.DESKTOP-DI5KTUG/Downloads/SQLiteDatabaseBrowserPortable/sistemaRegistro.db";
    $db = new PDO("sqlite:".$ruta);
    //Con la siguiente linea los errores SQL se convierte en excepciones
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function sacarDatosUsuarios(){
        global $db;

        $stmt = $db -> query("SELECT * FROM Usuarios");
        $datos = $stmt->fetchALL(PDO::FETCH_ASSOC);
        return $datos;
    }

    function existeUsuario($name){
        global $db;

        $stmt = $db ->prepare("SELECT COUNT(*) FROM Usuarios WHERE username = ?");
        $stmt -> execute([$name]);
        $resultado = $stmt -> fetchColumn();
        if($resultado > 0){
            $salida = true;
        }else{
            $salida = false;
        }
        return $salida;
    }

    function buscarPassUsuario($name){
        global $db;

        $stmt = $db ->prepare("SELECT password FROM Usuarios WHERE username = ?");
        $stmt -> execute([$name]);
        $salida = $stmt -> fetchColumn();
        return $salida;
    }
    
    function buscarId($name){
        global $db;

        $stmt = $db -> prepare("SELECT id FROM Usuario WHERE username = ?");
        $stmt -> execute([$name]);
        $salida = $stmt -> fetchColumn();
        return $salida;
    }

    function buscarRol($name){
        global $db;

        $stmt = $db -> prepare("SELECT rol FROM Usuarios WHERE username = ?");
        $stmt -> execute([$name]);
        $salida = $stmt -> fetchColumn();
        return $salida;
    }

    function addUsuario($username,$password,$rol='user'){
        global $db;

        //insertar nuevo usuario
        $stmt = $db -> prepare("INSERT INTO Usuarios (username, password, rol) VALUES (?,?,?)");
        $pCifrado = cifrar($password);
        $idRol = ($rol == 'admin')? 1 : 2;
        if($stmt -> execute([$username, $pCifrado, $idRol])){
            return true;
        }else{
            return false;
        }
    }

    function updateUsuario($campo, $valor,$id){
        global $db;

        $columnasPermitidas = ['password', 'rol'];

        if (!in_array($campo, $columnasPermitidas)) {
            throw new Exception("Campo no permitido");
        }

        // Si es el campo 'rol', convertir el valor
        if ($campo == 'rol') {
            $valor = ($valor == 'admin') ? 1 : 2;
        }
        
        $stmt = $db->prepare("UPDATE Usuarios SET `$campo` = ? WHERE id = ?");
        
        $stmt->execute([$valor,$id]);

        // Verificar cuántas filas se actualizaron
        $filasAfectadas = $stmt->rowCount();
        
        if ($filasAfectadas > 0) {
            return "✅ Usuario actualizado correctamente. Filas afectadas: $filasAfectadas";
        } else {
            return "⚠️ No se encontró el usuario con ID $id o los datos son iguales";
        }
    }

?>
