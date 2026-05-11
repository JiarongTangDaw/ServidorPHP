<?php
ini_set('display_errors', 0);  // ← desactiva errores HTML
error_reporting(E_ALL);

require_once "./utils.php";

$texto = $_GET['q'] ?? '';
$tipoaccesorio_id = $_GET['tipoaccesorio_id'] ?? 0;

$resultados = [];

if ($texto && $tipoaccesorio_id) {

    $terminos = '%' . strtolower($texto) . '%';  // ← convertir a minúsculas

    $stmt = $pdo->prepare("
        SELECT m2.modelo, ma.marca
        FROM compatibilidades c
        JOIN modelos m1 ON c.modelo1_id = m1.modelo_id
        JOIN marcas ma1 ON m1.marca_id = ma1.marca_id
        JOIN modelos m2 ON c.modelo2_id = m2.modelo_id
        JOIN marcas ma ON m2.marca_id = ma.marca_id
        WHERE c.tipoaccesorio_id = :tipo
        AND (
            LOWER(m1.modelo) LIKE :terminos1
            OR LOWER(ma1.marca) LIKE :terminos2
            OR LOWER(ma1.marca || ' ' || m1.modelo) LIKE :terminos3
            OR LOWER(m1.modelo || ' ' || ma1.marca) LIKE :terminos4
        )
        ORDER BY ma.marca, m2.modelo
    ");

    $stmt->execute([
        ':tipo'      => $tipoaccesorio_id,
        ':terminos1' => $terminos,
        ':terminos2' => $terminos,
        ':terminos3' => $terminos,
        ':terminos4' => $terminos,
    ]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $resultados[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($resultados);