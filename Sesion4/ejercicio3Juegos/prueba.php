<?php
    require_once "./conectores.php";

$conec = new Conectores();

//Me traigo de mi get el conector
$conector = $_GET['conector'] ?? '';

//Inicializo la variable de pintar la tabla
$arrFinalPlataformas=[];
$arrFinalPlataformas = $conec->procesarMySQL();
?>