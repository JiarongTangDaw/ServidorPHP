<?php

//Me traigo el fichero que tiene todas las librerias básicas del proyecto
require_once "./utils.php";

// Obtenemos la acción del query string
$accion = $_GET['action'] ?? '';
$list = $_GET['listado'] ?? false;

    //Extraigo el usuario conectado
    if (isset($_SESSION["usuario"])) {
        $usu_conectado = $_SESSION["usuario"];
        $idUsuarioConectado = $usu_conectado->getId();
    }

// Verificamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $email =  isset($_POST['email']) ? $_POST['email'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $rol = isset($_POST['rol']) ? (int)$_POST['rol'] : 2;
    $idUsuario = isset($_POST['idUsuario']) ? (int)$_POST['idUsuario'] : 0;

    switch ($accion) {
        case 'cerrarsesion':
            //Cerramos sesion 
            cerrarSesion();
            break;
        case 'login':

            //Validamos credenciales
            procesarLogin();
            break;
        case 'addUsuario':

            $error = procesarRegistrar();

            if($error != ''){
                if ($list) {
                    header('Location: registrar.php?error=' . $error);
                }else{
                    header('Location: registrar.php?action=registrar&error=' . $error);
                }
                exit();
            }

            $user = new Usuario ();
            $user->setEmail($email);
            $user->setNombre($nombre);
            $user->setApellidos($apellidos);
            $user->setUsuario($usuario);
            $user->setPassword($password);
            $user->setRolId($rol);

            $user->guardar($pdo);

            $mensaje = "Usuario añadido correctamente";

            if ($list) {
               header('Location: perfilUsuario.php?mensaje=' . $mensaje);
            }else{
                header('Location: index.php?mensaje=' . $mensaje);
            }
            exit();
            break;
        
        case 'modificar':
            $user = Usuario::obtenerPorId($pdo,$idUsuario);
            $mensaje = procesarModificar($user);
            if($rol === $user->getRolId()){
                $mensaje .= "No se ha realizado ninguna modificacion--";
            }else{
                $user->setRolId($rol);
                $user->guardar($pdo);
                $mensaje .= "Rol de usuario modificado correctamente ";
            }

            header('Location: perfilUsuario.php?mensaje=' . $mensaje);
            exit();
            break;

        case 'eliminar':
            $user = Usuario::obtenerPorId($pdo,$idUsuario);
            $user->eliminar($pdo);
            $mensaje .= "Usuario " . $user->getId() . " eliminado correctamente";
            header('Location: perfilUsuario.php?mensaje=' . $mensaje);
            exit();
            break;
        default:
            break;
    }

}

function procesarLogin(){
    global $usuario;
    global $password;
    global $pdo;

    $error = "";
    
    if ($usuario == "" || $password == ""){
        $error = "Debe rellenar todos los campos para iniciar sesion.";
        header('Location: login.php?error=' . $error );
    }else{
        $user = Usuario::login($pdo,$usuario,$password);

        if($user === null){
            $error = "Usuario o contraseña incorrecta";
            header('Location: login.php?error=' . $error );
        }else{
            crearSesion($user);
            header('Location: perfilUsuario.php?ok=1');
        }

        
    }
    exit();
}

function procesarRegistrar(){
    global $usuario;
    global $email;
    global $nombre;
    global $apellidos;
    global $password;

    $error ='';

    if ($usuario == "" || $email == "" || $nombre == "" || $apellidos == "" || $password == "") {
        $error = "Debe rellenar todos los campos para añadir nuevo usuario";
    }else{
        if(!comprobarPatronEmail($email)){
            $error .= "La estructura del email introduciodo no es correcto--";
        }

        if(!comprobarPassword($password)){
            $error .= "La estructura de la contraseña es incorrecto: Debe tener minimo 8 digitos, minimo una letra en mayuscula, minimo una letra en minuscula, minimo un numero y minimo un caracter especial--";
        }
    }

    return $error;
}

function procesarModificar(Usuario $user){
    global $usuario;
    global $email;
    global $nombre;
    global $apellidos;
    
    $mensaje ='';

    if ($usuario != $user->getUsuario() || $email != $user->getEmail() || $nombre != $user->getNombre() || $apellidos != $user->getApellidos()) {
        $mensaje = "Solo se puede modificar el campo rol--";
    }

    return $mensaje;
}

