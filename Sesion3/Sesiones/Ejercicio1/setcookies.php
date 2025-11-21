<?php // parte ejercicio 4
    function incCookie()  {
        if (isset($_COOKIE['visita'])) {
            $valor = (int) $_COOKIE['visita'] + 1;// Incrementar el valor de la cookie
        } else {
            $valor =  1;// Incrementar el valor de la cookie
        }
        setcookie("visita", $valor, time() + 60); // La cookie dura 1 minuto
        return $valor;
    }
?>