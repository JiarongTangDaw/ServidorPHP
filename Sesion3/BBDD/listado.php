<?php
    require_once './utils.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado Usuarios</title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="./funciones.js" defer></script>
</head>
<body>
    <h1>Listado de usuarios</h1>
    <?php
        $listaUsuarios = sacarDatosUsuarios();
    ?>
    <form action="./listado.php" method="post" id="listado">
        <input type="hidden" name="rol" id="rol">
        <input type="hidden" name="id" id="id">
        <table>
            <thead>
                <tr>
                    <th> Username </th>
                    <th> Rol </th>
                    <th> Acciones </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($listaUsuarios as $usuario) {
                        if($usuario['username'] != $_SESSION['username']){
                ?> 
                    <tr>
                        <td id='name<?= $usuario['id'] ?>'> <?= $usuario['username'] ?> </td>
                        <td>
                            <select id='rol<?= $usuario['id'] ?>'>
                                <option value="admin" <?= $usuario['rol'] === 1 ? 'selected' : '' ?>>Admin</option>
                                <option value="user" <?= $usuario['rol'] === 2 ? 'selected' : '' ?>>User</option>
                            </select>
                        </td>
                        <td>
                            <input type="button" value="Modificar" onClick ="modificar('<?= $usuario['id'] ?>')">
                            <input type="button" value="eliminar" onClick ="eliminar('<?= $usuario['id'] ?>')">
                        </td>
                    </tr>
                <?php    }} ?>
            </tbody>
        </table>
    </form>

</body>
</html>