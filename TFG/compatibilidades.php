<?php
require_once "./utils.php";

// 🔥 Consulta con JOINs para mostrar nombres reales
$stmt = $pdo->query("
    SELECT c.compatibilidad_id,
           m1.modelo AS modelo1,
           ma1.marca AS marca1,
           m2.modelo AS modelo2,
           ma2.marca AS marca2,
           t.tipoaccesorio
    FROM compatibilidades c
    JOIN modelos m1 ON c.modelo1_id = m1.modelo_id
    JOIN marcas ma1 ON m1.marca_id = ma1.marca_id
    JOIN modelos m2 ON c.modelo2_id = m2.modelo_id
    JOIN marcas ma2 ON m2.marca_id = ma2.marca_id
    JOIN tipoaccesorios t ON c.tipoaccesorio_id = t.tipoaccesorio_id
");

echo "<div class='seccion-header'>";
echo "<h1>Compatibilidades</h1>";
echo "<a class='btn anadir' href='registrarCompatibilidad.php'>➕ Añadir Compatibilidad</a>";
echo "</div>";

echo "<table>
<tr>
    <th>ID</th>
    <th>Modelo 1</th>
    <th>Modelo 2</th>
    <th>Tipo Accesorio</th>
    <th>Acciones</th>
</tr>";

while ($c = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo "<tr>
        <td>{$c['compatibilidad_id']}</td>
        <td>{$c['marca1']} - {$c['modelo1']}</td>
        <td>{$c['marca2']} - {$c['modelo2']}</td>
        <td>{$c['tipoAccesorio']}</td>
        <td>
            <button class='btn borrar' onclick='deleteCompatibilidad({$c['compatibilidad_id']})'>
                Eliminar
            </button>
        </td>
    </tr>";
}

echo "</table>";