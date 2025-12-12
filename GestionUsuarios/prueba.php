<?php

require_once "./Usuarios.php";
require_once "db.php";
$db = new BaseDatos();
$pdo = $db->getPdo();

$usuario = 'jiarong';
$password = '1234';
$usuarios = Usuario::login($pdo,$usuario,$password);

print_r($usuarios);
?>
