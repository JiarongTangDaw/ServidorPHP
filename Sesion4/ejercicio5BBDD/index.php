<?php
    try {
        $pdo = new PDO('mysql:host=127.0.0.1:3307;dbname=videojuegos_db', 'root', '');
        echo "¡Conexión establecida!";
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
?>