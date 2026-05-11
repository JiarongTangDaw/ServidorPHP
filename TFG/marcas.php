<?php
require_once "./Marca.php";

$lista = Marca::obtenerTodos($pdo);

echo "<div class='seccion-header'>";
echo "<h1>Marcas</h1>";
echo "<a class='btn anadir' href='registrarMarca.php'>➕ Añadir Marca</a>";
echo "</div>";

echo "<table>
<tr>
    <th>ID</th>
    <th>Marca</th>
    <th>Acciones</th>
</tr>";

foreach ($lista as $m) {
    echo "<tr>
        <td>{$m->getId()}</td>
        <td>{$m->getMarca()}</td>
        <td>
            <a class='btn editar' href='registrarMarca.php?action=modificar&id={$m->getId()}'>Editar</a>
            <button class='btn borrar' onclick='deleteMarca({$m->getId()})'>Eliminar</button>
        </td>
    </tr>";
}

echo "</table>";