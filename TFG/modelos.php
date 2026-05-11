<?php
require_once "./utils.php";

$stmt = $pdo->query("
    SELECT mo.modelo_id, mo.modelo, ma.marca
    FROM modelos mo
    JOIN marcas ma ON mo.marca_id = ma.marca_id
");

echo "<div class='seccion-header'>";
echo "<h1>Modelos</h1>";
echo "<a class='btn anadir' href='registrarModelo.php'>➕ Añadir Modelo</a>";
echo "</div>";

echo "<table>
<tr>
    <th>ID</th>
    <th>Modelo</th>
    <th>Marca</th>
    <th>Acciones</th>
</tr>";

while ($m = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
        <td>{$m['modelo_id']}</td>
        <td>{$m['modelo']}</td>
        <td>{$m['marca']}</td>
        <td>
            <a class='btn editar' href='registrarModelo.php?modelo_id={$m['modelo_id']}'>Editar</a>
            <button class='btn borrar' onclick='deleteModelo({$m['modelo_id']})'>Eliminar</button>
        </td>
    </tr>";
}

echo "</table>";