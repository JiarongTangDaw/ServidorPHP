<?php
require_once "./utils.php";

$q = $_GET['q'] ?? '';

$stmt = $pdo->prepare("SELECT modelo_id, modelo FROM modelos WHERE modelo LIKE :q LIMIT 10");
$stmt->execute([':q' => "%$q%"]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

?>