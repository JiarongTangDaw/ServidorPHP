<?php
    require_once "../ejercicio3Juegos/conectores.php";
    $conec = new Conectores();
    $videojuegos = $conec ->procesarMySQL();
    
    $cadena = 'mysql:host=localhost:3307;dbname=videojuegos_db';
    $pdo = new PDO($cadena, 'root', '');

    
?>