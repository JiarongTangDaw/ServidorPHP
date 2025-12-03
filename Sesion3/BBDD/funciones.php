<?php
    require_once './db.php';
    require_once './encriptador.php';
    require_once './error.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_GET['action']?? '';

        $rol = $_POST['rol']??"";
        $id = $_POST['id']??"";
        $password = $_POST['password'] ?? '';

        
        switch ($action) {
            case 'modificar':
                if($rol != ""){
                    updateUsuario('rol',$rol,$id);
                    header("Location: listado.php");
                    exit();
                }else{
                    updateUsuario('password',$password,$id);
                    header("Location: profile.php");
                    exit();
                }
                
                break;
            case 'eliminar':
                $idRol = buscarRol($id);
                if ($idRol == 1){
                    $_SESSION['mensaje'] = "No se puede elimnar un administrador";
                }else{
                    deleteUsuario($id);
                    $_SESSION['mensaje'] = "Usuario eliminado con exito";
                }
                header("Location: listado.php");
                exit();
                break;
            
            default:
                echo "esto es default";
                break;
        }
    }

    function validarUsername($name){
       $patron = "/^[a-zA-Z][a-zA-Z0-9_]*$/";

       $name = sanetizar($name);
       $correcto = false;
       if(preg_match($patron,$name)){
            $correcto = true;
       }
       return $correcto;
    }

    function sanetizar($dato){

       $dato = strip_tags($dato);
       $dato = htmlspecialchars($dato);

       return $dato;
    }

?>