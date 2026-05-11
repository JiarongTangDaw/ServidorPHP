<?php

require_once "./utils.php";

$accion = $_GET['action'] ?? '';
$list = $_GET['listado'] ?? false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $idUsuario = isset($_POST['idUsuario']) ? (int)$_POST['idUsuario'] : 0;

    switch ($accion) {

        case 'cerrarsesion':
            cerrarSesion();
            break;

        case 'login':
            procesarLogin();
            break;

        default:
            break;
    }
}

exit();


// ===== FUNCIONES =====

function procesarLogin(){
    global $pdo, $usuario, $password;

    $user = Usuario::login($pdo, $usuario, $password);

    if ($user === null) {
        header('Location: login.php?error=Usuario o contraseña incorrecta');
    } else {
        crearSesion($user);
        header('Location: panelAdmin.php?ok=1');
    }
}

?>