<?php

// Me traigo el fichero que tiene todas las librerias básicas del proyecto (incluye DB, sesión, utilidades, etc.)
require_once "./utils.php";

// Obtenemos la acción del query string (cerrarsesion, login, addUsuario, modificar, eliminar)
$accion = $_GET['action'] ?? '';
// Variable booleana para saber si el registro o modificación viene del panel de admin (listado=true)
$list = $_GET['listado'] ?? false;


// Verificamos si se ha enviado el formulario por el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recogida de datos del formulario POST con operador ternario para evitar errores
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $email =  isset($_POST['email']) ? $_POST['email'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    // El rol por defecto es 2 (Usuario normal)
    $rol = isset($_POST['rol']) ? (int)$_POST['rol'] : 2;
    // idUsuario es necesario para modificar o eliminar
    $idUsuario = isset($_POST['idUsuario']) ? (int)$_POST['idUsuario'] : 0;

    switch ($accion) {
        case 'cerrarsesion':
            // Cerramos sesion (función de sesion.php, incluida en utils.php)
            cerrarSesion();
            break;
        case 'login':

            // Validamos credenciales (función definida más abajo)
            procesarLogin();
            break;
        case 'addUsuario':

            // 1. Validar los datos de registro/creación
            $error = procesarRegistrar();

            if($error != ''){
                // Si hay errores, redirigir al formulario de registro con el mensaje de error

                if ($list) {
                    // Si viene del listado de admin, redirige al registrar.php con el error
                    header('Location: registrar.php?error=' . $error . '&listado=true');
                } else {
                    // Si es un registro público, redirige al registrar.php con el error
                    header('Location: registrar.php?action=registrar&error=' . $error );
                }
                exit();
            }

            // 2. Crear nuevo objeto Usuario e inyectar datos
            $user = new Usuario ();
            $user->setUsuario($usuario);
            $user->setEmail($email);
            $user->setNombre($nombre);
            $user->setApellidos($apellidos);
            $user->setPassword($password);
            $user->setRolId($rol);

            // 3. Guardar el nuevo usuario (la contraseña se hashea dentro del método guardar)
            $user->guardar($pdo);

            $mensaje = "Usuario " . $user->getId() . " creado correctamente";

            if ($list) {
                // Si viene del listado admin, redirige al listado
                header('Location: perfilUsuario.php?mensaje=' . $mensaje);
            } else {
                // Si es registro público, inicia sesión automáticamente y redirige al perfil
                crearSesion($user);
                header('Location: perfilUsuario.php');
            }
            exit();

            break;
        
        case 'modificar':
            // 1. Obtener el usuario a modificar
            $user = Usuario::obtenerPorId($pdo,$idUsuario);
            
            // 2. Validar que no se hayan intentado modificar campos no permitidos (función abajo)
            $mensaje = procesarModificar($user);

            if($mensaje != ''){
                // Si se detecta un error de cambio no permitido
                header('Location: modificar.php?usuario_id=' . $idUsuario . '&error=' . $mensaje);
            } else {
                // Si todo es correcto, solo actualizamos el rol
                $user->setRolId($rol);
                // Guardar los cambios (la función guardar detecta que es un UPDATE)
                $user->guardar($pdo);
                $mensaje = "Usuario " . $user->getId() . " modificado correctamente";
                // Redirigir al listado
                header('Location: perfilUsuario.php?mensaje=' . $mensaje);
            }
            exit();
            break;

        case 'eliminar':
            // 1. Obtener el usuario por ID
            $user = Usuario::obtenerPorId($pdo,$idUsuario);
            // 2. Eliminar de la base de datos
            $user->eliminar($pdo);
            $mensaje = "Usuario " . $user->getId() . " eliminado correctamente";
            // 3. Redirigir al listado
            header('Location: perfilUsuario.php?mensaje=' . $mensaje);
            exit();
            break;

        default:
            break;
    }

}
exit();
// Fin del bloque de procesamiento POST

/**
 * Función interna para manejar la lógica de Login.
 */
function procesarLogin(){
    global $pdo;
    global $usuario;
    global $password;

    // Llama al método estático login de la clase Usuario (verifica hash + sal)
    $user = Usuario::login($pdo, $usuario, $password);

    if($user === null){
        // Si login falla, redirigir al login con mensaje de error
        $error = "Usuario o contraseña incorrecta";
        header('Location: login.php?error=' . $error );
    }else{
        // Si es exitoso, crear la sesión y redirigir al perfil
        crearSesion($user);
        header('Location: perfilUsuario.php?ok=1');
    }

    
}

/**
 * Función interna para validar los datos de registro (addUsuario).
 * Retorna un string de errores separados por '--' o un string vacío.
 */
function procesarRegistrar(){
    global $usuario;
    global $email;
    global $nombre;
    global $apellidos;
    global $password;

    $error ='';

    // Comprobación de campos obligatorios
    if ($usuario == "" || $email == "" || $nombre == "" || $apellidos == "" || $password == "") {
        $error = "Debe rellenar todos los campos para añadir nuevo usuario";
    }else{
        // Validación de formatos con funciones de utils.php
        if(!comprobarPatronEmail($email)){
            $error .= "La estructura del email introduciodo no es correcto--";
        }

        if(!comprobarPassword($password)){
            // Mensaje de error detallado sobre los requisitos de la contraseña
            $error .= "La estructura de la contraseña es incorrecto: Debe tener minimo 8 digitos, minimo una letra en mayuscula, minimo una letra en minuscula, minimo un numero y minimo un caracter especial--";
        }
    }

    return $error;
}

/**
 * Función interna para validar los datos de modificación de usuario.
 * Nota: En este sistema, solo se permite actualizar el Rol, los demás campos se validan
 * para detectar intentos de modificación.
 * Retorna un string de errores si se intentan cambiar otros campos.
 */
function procesarModificar(Usuario $user){
    global $usuario;
    global $email;
    global $nombre;
    global $apellidos;
    
    $mensaje ='';

    // Se verifica que el usuario NO haya modificado campos no controlados
    if($user->getUsuario() !== $usuario || $user->getEmail() !== $email || $user->getNombre() !== $nombre || $user->getApellidos() !== $apellidos){
        $mensaje .= " Solo se puede modificar el Rol del usuario";
    }

    return $mensaje;
}
?>