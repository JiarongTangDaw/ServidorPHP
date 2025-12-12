<?php

//Me traigo el fichero que tiene todas las librerias básicas del proyecto
require_once "utils.php";

// Obtenemos la acción del query string
$accion = $_GET['action'] ?? '';


// Verificamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($accion) {
        case 'cerrarsesion':
            //Cerramos sesion 
            cerrarSesion();
            break;
        case 'login':
            //Reocojo los valores del usuario
            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';

            //Validamos credenciales
            procesarLogin();
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
