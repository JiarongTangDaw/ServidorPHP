<?php
    require_once './utils.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_GET['action']?? '';

        $rol = $_POST['rol']??"";
        $id = $_POST['id']??"";
        $password = $_POST['password'] ?? '';

        
        switch ($action) {
            case 'modificar':
                try {
                    $salida = updateUsuario("rol",$rol,$id);
                    echo $salida;
                } catch (Exception $th) {
                    echo "error";
                }
                break;
            
            default:
                # code...
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