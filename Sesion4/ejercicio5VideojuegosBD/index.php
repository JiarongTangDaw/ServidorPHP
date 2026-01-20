<?php
    $listavidejuegos = [];
    try {
        $pdo = new PDO('mysql:host=localhost:3307;dbname=videojuegos_db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET NAMES 'utf8'");
        echo "<h4>Conexión exitosa</h4>";
        $sql = "SELECT V.id, V.titulo, P.nombre AS plataforma, V.metacritic, V.portada 
                FROM juegos V 
                INNER JOIN plataformas P ON V.plataforma_id = P.id";
        $lista = $pdo->query($sql);
        echo "<h4>Lista de videojuegos</h4>";
        while ($videojuego = $lista->fetch()) {
            $plataforma = $videojuego['plataforma'];
            $keys = array_keys($listavidejuegos);
            if(!in_array($plataforma, $keys)){
                $listavideojuegos[$plataforma] = [];
            }
            $listavidejuegos[$plataforma][] = $videojuego;
        };
        foreach ($listavidejuegos as $key=>$juegos) {
            echo "<h2>" . htmlspecialchars($key) . "</h2>";
            foreach ($juegos as $juego) {
                echo "<b>ID_Videojuego: ". htmlspecialchars($juego['id']) . "</b><br/>";
                echo "Título: " . htmlspecialchars($juego['titulo']) . "<br/>";
                echo "Plataforma: " . htmlspecialchars($juego['plataforma']) . "<br/>";
                echo "Metacritic: " . htmlspecialchars($juego['metacritic']) . "<br/>";
                echo "<img src='" . htmlspecialchars($juego['portada']) . "' alt='". htmlspecialchars($juego['titulo']) . "' width='150'><br/><br/>";
            }
        }
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
?>