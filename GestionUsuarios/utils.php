<?php

//Importo mi fichero de configuracion
$config = require_once "./config.php";

//Incluyo mi libreria de encriptacion
require_once "./encriptador.php";

//Incluyo mi control de errores
require_once "./error.php";

//Incluyo mi sanetizacion
require_once "./sanetizar.php";

//Incluyo mi gestion de la sesion
require_once "./sesion.php";

//Me traigo la bbdd y la instancio para poder usarla
require_once "./db.php";
$db = new BaseDatos();
$pdo = $db->getPdo();

function comprobarPatronEmail($email): bool
{
    $salida = true;
    $patron = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $salida = preg_match($patron, $email);

    return $salida;
}

function comprobarDocumento($doc): bool
{
    $salida = true;
    $patron = "/^(?:\d{8}[A-HJ-NP-TV-Z]|[XYZ]\d{7}[A-HJ-NP-TV-Z]|[ABCDEFGHJKLMNPQRSUVW]\d{7}[0-9A-J])$/i";
    $salida = preg_match($patron, $doc);

    return $salida;
}

function comprobarPassword($password): bool
{
    $salida = true;
    if ($password != "") {
        $patron = "/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/";
        $salida = preg_match($patron, $password);
    }

    return $salida;
}

function comprobarTelefono($tel): bool
{
    $salida = true;
    if ($tel != "") {
        $patron = '/^(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}$/';
        $salida = preg_match($patron, $tel);
    }

    return $salida;
}

function comprobarEdad($edad): bool
{
    $salida = true;
    if($edad < 18 || $edad >= 100){
        $salida = false;
    }

    return $salida;
}