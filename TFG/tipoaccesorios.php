<?php
require_once "./TipoAccesorio.php";

$lista = TipoAccesorio::obtenerTodos($pdo);

echo "<div class='seccion-header'>";
echo "<h1>Tipos de Accesorio</h1>";
echo "<a class='btn anadir' href='registrarTipoAccesorio.php'>➕ Añadir</a>";
echo "</div>";

echo "<table>
<tr>
    <th>ID</th>
    <th>Tipo</th>
    <th>Acciones</th>
</tr>";

foreach ($lista as $t) {
    echo "<tr>
        <td>{$t->getId()}</td>
        <td>{$t->getTipoAccesorio()}</td>
        <td>
            <a class='btn editar' href='registrarTipoAccesorio.php?action=modificar&tipoaccesorio_id={$t->getId()}'>Editar</a>
            <button class='btn borrar' onclick='deleteTipoAccesorio({$t->getId()})'>Eliminar</button>
        </td>
    </tr>";
}

echo "</table>";