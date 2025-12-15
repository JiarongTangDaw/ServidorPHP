<?php
    require_once './utils.php';
    require_once './Clientes.php';

    // Obtenemos la acción del query string
    $accion = $_GET['action'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email =  isset($_POST['email']) ? $_POST['email'] : '';
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
        $cif = isset($_POST['cif']) ? $_POST['cif'] : '';
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
        $edad = isset($_POST['edad']) ? (int) $_POST['edad'] : 0;
        $contacto = isset($_POST['contacto']) ? (int) $_POST['contacto'] : 0;
        $idCliente = isset($_POST['idCliente']) ? (int) $_POST['idCliente'] : 0;
        
        switch ($accion) {
            case 'addCliente':

                $error = validar();

                if($error != ''){
                    header('Location: registrarCliente.php?error=' . $error);
                    exit();
                }

                $cliente = new Cliente();
                $cliente->setNombre($nombre);
                $cliente->setApellidos($apellidos);
                $cliente->setEmail($email);
                $cliente->setCIF($cif);
                $cliente->setEdad($edad);
                $cliente->setTelefono($telefono);
                if($contacto != 0){
                    $cliente->setContactoId($contacto);
                }
                $cliente->guardar($pdo);

                $mensaje = "Nuevo Cliente añadido correctamente";

                header('Location: perfilClientes.php?mensaje=' . $mensaje);
                exit();

                break;
            
            case 'modificar':
                $error = validar();

                if($error != ''){
                    header('Location: registrarCliente.php?error=' . $error);
                    exit();
                }
                
                $cliente = Cliente::obtenerPorId($pdo,$idCliente);
                $cliente->setNombre($nombre);
                $cliente->setApellidos($apellidos);
                $cliente->setEmail($email);
                $cliente->setCIF($cif);
                $cliente->setEdad($edad);
                $cliente->setTelefono($telefono);
                $cliente->setContactoId($contacto);
                $cliente->guardar($pdo);

                $mensaje = "Cliente modificado correctamente";

                header('Location: perfilClientes.php?mensaje=' . $mensaje);
                exit();
                break;

            case 'eliminar':
                $cliente = Cliente::obtenerPorId($pdo,$idCliente);
                $cliente->eliminar($pdo);
                $mensaje .= "Cliente " . $cliente->getId() . " eliminado correctamente";
                header('Location: perfilClientes.php?mensaje=' . $mensaje);
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

        if ($nombre == '' || $apellidos == '' || $email == '' || $telefono == '' || $cif == '' || $edad == 0) {
            $error = 'NO puede haber campos vacios';
        }else{
            if (!comprobarPatronEmail($email)) {
                $error .= 'Formato de Email incorrecto--';
            }
            if (!comprobarTelefono($telefono)) {
                $error .= 'Formato de telefono incorrecto--';
            }
            if (!comprobarEdad($edad)) {
                $error .= 'Rango de edad introducido incorrecto--';
            }
            if (!comprobarDocumento($cif)) {
                $error .= 'Formato de CIF introducido incorrecto--';
            }
        }

        return $error;
    }
?>