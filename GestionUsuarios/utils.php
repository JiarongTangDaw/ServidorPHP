<?php

// === IMPORTACIÓN DE LIBRERÍAS Y CONFIGURACIÓN ===

// Importo mi fichero de configuracion (rutas, claves, etc.)
$config = require_once "./config.php";

// Incluyo librería personalizada de encriptación
require_once "./encriptador.php";

// Incluyo control de errores personalizado
require_once "./error.php";

// Incluyo funciones de sanitización para limpiar inputs
require_once "./sanetizar.php";

// Incluyo gestión de la sesión (start session, check session)
require_once "./sesion.php";

// Instancio la base de datos mediante PDO
require_once "./db.php";
$db = new BaseDatos();
$pdo = $db->getPdo();

// === FUNCIONES DE VALIDACIÓN (RegEx) ===

/**
 * Valida si el formato del email es correcto.
 * @return bool true si es válido
 */
function comprobarPatronEmail($email): bool
{
    $salida = true;
    // Patrón estándar de email: texto @ texto . texto
    $patron = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $salida = preg_match($patron, $email);

    return $salida;
}

/**
 * Valida DNI o NIE español.
 * Soporta 8 dígitos + letra (DNI) o X/Y/Z + 7 dígitos + letra (NIE).
 */
function comprobarDocumento($doc): bool
{
    $salida = true;
    // Expresión regular compleja para DNI y NIE
    $patron = "/^(?:\d{8}[A-HJ-NP-TV-Z]|[XYZ]\d{7}[A-HJ-NP-TV-Z]|[ABCDEFGHJKLMNPQRSUVW]\d{7}[0-9A-J])$/i";
    $salida = preg_match($patron, $doc);

    return $salida;
}

/**
 * Valida la robustez de la contraseña.
 * Requisitos: Mínimo 8 caracteres, 1 mayúscula, 1 número, 1 carácter especial.
 */
function comprobarPassword($password): bool
{
    $salida = true;
    if ($password != "") {
        // Lookaheads (?=) aseguran que contenga los tipos de caracteres requeridos
        $patron = "/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/";
        $salida = preg_match($patron, $password);
    }

    return $salida;
}

/**
 * Valida teléfonos españoles (móviles empezando por 6, 7, 8, 9).
 * Acepta prefijo +34 opcional.
 */
function comprobarTelefono($tel): bool
{
    $salida = true;
    if ($tel != "") {
        $patron = '/^(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}$/';
        $salida = preg_match($patron, $tel);
    }

    return $salida;
}

/**
 * Valida que la edad esté en un rango lógico (18 a 99 años).
 */
function comprobarEdad($edad): bool
{
    $salida = true;
    if($edad < 18 || $edad >= 100){
        $salida = false;
    }

    return $salida;
}