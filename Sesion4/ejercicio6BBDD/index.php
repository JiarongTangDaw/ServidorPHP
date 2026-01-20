<?php
    try {
        $pdo = new PDO('mysql:host=127.0.0.1:3307;dbname=videojuegos_db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET NAMES 'utf8'");
        echo "<h4>Conexión exitosa</h4>";
        
        //* Inserción de una nueva plataforma
        /*try {
            $sql = "INSERT INTO plataformas (nombre) VALUES ('prueba')";
            $filasInsertadas = $pdo->exec($sql);
            echo "Se han añadido $filasInsertadas filas<br/>";
        } catch (PDOException $excepcion) {
            echo "Error en la inserción: " . $excepcion->getMessage();
        }

        try {
            $sql = "SELECT * FROM plataformas";
            $lista = $pdo->query($sql);
            echo "<h4>Lista de plataformas</h4>";
            while ($plataforma = $lista->fetch()) {
                echo "ID: " . $plataforma['id'] . "<br/>";
                echo "Nombre: " . $plataforma['nombre'] . "<br/>";
            }
        } catch (PDOException $excepcion) {
            echo "Error en la consulta: " . $excepcion->getMessage();
        }*/
        
        //*eliminar base de datos de videojuegos_db
        /*try {
            $sql = "DROP DATABASE videojuegos_db";
            $pdo->exec($sql);
            echo "Base de datos eliminada correctamente.<br/>";
        } catch (PDOException $excepcion) {
            echo "Error al eliminar la base de datos: " . $excepcion->getMessage();
        }*/

    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
?>