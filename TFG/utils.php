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

?>