<?php
    require_once './db.php';
    require_once './encriptador.php';
    require_once './error.php';

    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
        $action = $_GET['action']?? '';

        $rol = $_POST['rol']??"";
        $id = $_POST['id']??"";
        $oldPassword = $_POST['oldPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $username = $_SESSION['username']??'';

        
        switch ($action) {
            case 'modificar':
                updateUsuario('rol',$rol,$id);
                $_SESSION['mensaje'] = 'Usuario modificado con exito';
                header("Location: listado.php");
                exit();
                
                break;
            case 'eliminar':
                $idRol = buscarRol($username);
                if ($idRol == 1){
                    $_SESSION['error'] = "No se puede elimnar un administrador";
                }else{
                    deleteUsuario($id);
                    $_SESSION['mensaje'] = "Usuario eliminado con exito";
                }
                header("Location: listado.php");
                exit();
                break;

            case 'modificarPassword':
                $passBBDD = buscarPassUsuario($username);
                if ($oldPassword != descifrar($passBBDD)){
                    $_SESSION['error'] = "Contraseña actual incorrecta";
                }else{
                    updateUsuario('password',$newPassword,$id);
                    $_SESSION['mensaje'] = "Contraseña cambiada correctamente";
                }
                header("Location: profile.php");
                exit();
                
                break;
            
            case 'logout':
                session_unset();
                session_destroy();
                header("Location: index.php");
                exit();
                break;
            
            default:
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