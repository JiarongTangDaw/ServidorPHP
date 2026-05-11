<?php

// === SCRIPT DE INICIALIZACIÓN - EJECUTAR SOLO UNA VEZ ===
// ⚠️ BORRAR tras ejecutarlo.

// Cargamos config manualmente
$config = require_once "./config.php";

// Ruta directa al archivo de base de datos
$ruta = __DIR__ . '/' . $config['database']['dbname'];

echo "Ruta de la BD: " . $ruta . "<br>";
echo "¿Existe el archivo? " . (file_exists($ruta) ? "✅ SÍ" : "❌ NO") . "<br><br>";

try {
    $pdo = new PDO('sqlite:' . $ruta, null, null, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Crear tabla si no existe
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            usuario_id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario    TEXT NOT NULL UNIQUE,
            password   TEXT NOT NULL
        )
    ");

    // Comprobar si ya existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
    $stmt->execute([':usuario' => 'admin']);
    $existe = $stmt->fetchColumn();

    if ($existe > 0) {
        echo "⚠️ El usuario <strong>admin</strong> ya existe. No se ha creado nada.";
    } else {
        $claveEC  = $config['pass']['hash'];
        $hash     = password_hash('918950738jT*' . $claveEC, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password) VALUES (:usuario, :password)");
        $stmt->execute([
            ':usuario'  => 'admin',
            ':password' => $hash,
        ]);

        echo "✅ Usuario <strong>admin</strong> creado correctamente con ID: " . $pdo->lastInsertId();
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}