<?php
// CONEXIÓN A MONGODB CON EXTENSIÓN NATIVA
try {
    // 1. Conexión al servidor MongoDB
    $manager = new MongoDB\Driver\Manager('mongodb://jorge:1234@192.168.108.100:27017/videojuegos_db_jia');
    
    // 2. Comando para crear colección 'filas_alumnos'
    $command = new MongoDB\Driver\Command([
        'create' => 'filas_alumnos'
    ]);
    
    // 3. Ejecutar comando en TU base de datos
    $manager->executeCommand('videojuegos_db_jia', $command);
    
    echo "✅ Colección 'filas_alumnos' creada en videojuegos_db_jia";
    
    // 4. Insertar documento de ejemplo
    $bulk = new MongoDB\Driver\BulkWrite;
    $documento = [
        'numero' => 1,
        'alumno' => [
            'nombre' => 'Jia',
            'apellidos' => 'TuApellido',
            'sexo' => 'femenino',
            'es_profe_sexi' => false
        ]
    ];
    
    $bulk->insert($documento);
    $manager->executeBulkWrite('videojuegos_db_jia.filas_alumnos', $bulk);
    
    echo "<br>✅ Documento de ejemplo insertado";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>