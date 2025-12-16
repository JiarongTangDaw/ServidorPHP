<?php
    require_once './utils.php';
    require_once './Contactos.php';

    // Obtenemos la acción del query string
    $accion = $_GET['action'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email =  isset($_POST['email']) ? $_POST['email'] : '';
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
        $idContacto = isset($_POST['idContacto']) ? (int) $_POST['idContacto'] : 0;
        
        switch ($accion) {
            case 'addContacto':

                $error = validar();

                if($error != ''){
                    header('Location: registrarContacto.php?error=' . $error );
                    exit();
                }

                $contacto = new Contacto();
                $contacto->setNombre($nombre);
                $contacto->setApellidos($apellidos);
                $contacto->setEmail($email);
                $contacto->setTelefono($telefono);
                
                $contacto->guardar($pdo);

                $mensaje = "Nuevo Contacto añadido correctamente";

                header('Location: perfilContactos.php?mensaje=' . $mensaje);
                exit();

                break;
            
            case 'modificar':
                $error = validar();

                if($error != ''){
                    header('Location: registrarContacto.php?error=' . $error . '&contacto_id=' . $idContacto);
                    exit();
                }
                
                $contacto = Contacto::obtenerPorId($pdo,$idContacto);
                $contacto->setNombre($nombre);
                $contacto->setApellidos($apellidos);
                $contacto->setEmail($email);
                $contacto->setTelefono($telefono);
                $contacto->guardar($pdo);

                $mensaje = "Contacto modificado correctamente";

                header('Location: perfilContactos.php?mensaje=' . $mensaje);
                exit();
                break;

            case 'eliminar':
                $contacto = Contacto::obtenerPorId($pdo,$idContacto);
                $contacto->eliminar($pdo);
                $mensaje .= "Contacto " . $contacto->getId() . " eliminado correctamente";
                header('Location: perfilContactos.php?mensaje=' . $mensaje);
                exit();
                break;
            default:
                break;
        }

    }

    function validar (){

        global $nombre;
        global $apellidos;
        global $email;
        global $telefono;
        global $cif;
        global $edad;

        $error = '';

        if ($nombre == '' || $apellidos == '' || $email == '' || $telefono == '' ) {
            $error = 'NO puede haber campos vacios';
        }else{
            if (!comprobarPatronEmail($email)) {
                $error .= 'Formato de Email incorrecto--';
            }
            if (!comprobarTelefono($telefono)) {
                $error .= 'Formato de telefono incorrecto--';
            }
        }

        return $error;
    }
?>