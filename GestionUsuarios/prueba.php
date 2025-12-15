<?php

require_once "./Usuarios.php";
require_once "db.php";
require_once "sanetizar.php";
$db = new BaseDatos();
$pdo = $db->getPdo();

$usuario = 'jiarong';
$password = '1234';
$usuarios = Usuario::login($pdo,$usuario,$password);

$mensaje = $_GET['mensaje']?? 'no hay nada';
echo $mensaje;
?>
