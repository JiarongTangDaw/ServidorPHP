<?php
    // Incluye utilidades y la clase Cliente
    require_once "./utils.php";
    require_once "./Clientes.php";

    // Obtiene todos los clientes de la BD
    $listaClientes = Cliente::obtenerTodos($pdo);

    // Extrae el usuario conectado y su rol para control de permisos
    $rol_id_usuario = 0; // Rol por defecto
    if (isset($_SESSION["usuario"])) {
        $usu_conectado = $_SESSION["usuario"];
        $rol_id_usuario = $usu_conectado->getRolId();
    }

    // Muestra alertas (mensajes de éxito/error) si existen en la URL
    $mensaje = $_GET['mensaje']?? '';

    if($mensaje != ''){
        // Reemplaza los separadores '--' por saltos de línea para la alerta
        echo "<script>alert('" . str_replace("--", "\\n", $mensaje) . "')</script>";
    }

?>


<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Listado de Clientes</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="tabla-contenedor">

        <h1>Listado de Clientes</h1>
        <button class="btn cerrarsesion" onclick="navegar('usuario')">
            Usuarios
        </button>
        <button class="btn cerrarsesion" onclick="navegar('contacto')">
            Contactos
        </button>
        <?php if ($rol_id_usuario == 1): ?>
            <a href="./registrarCliente.php" class="btn primary anadir">➕ Añadir Cliente</a>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Edad</th>
                <th>Email</th>
                <th>CIF</th>
                <th>Telefono</th>
                <?php if ($rol_id_usuario == 1): ?>
                <th>Acciones</th>
                <?php endif; ?>
            </tr>

            <?php foreach ($listaClientes as $c): ?>
            <tr>
                <td><?= $c->getId() ?></td>
                <td><?= $c->getNombre() ?></td>
                <td><?= $c->getApellidos() ?></td>
                <td><?= $c->getEdad() ?></td>
                <td><?= $c->getEmail() ?></td>
                <td><?= $c->getCIF() ?></td>
                <td><?= $c->getTelefono() ?></td>
                </td>
                <?php if ($rol_id_usuario == 1): ?>
                <td class="acciones">
                    <button class="btn editar"
                        onclick="contactoCliente(<?= $c->getId() ?>)">
                        Lista Contactos de Cliente
                    </button>

                    <a class="btn editar"
                        href="registrarCliente.php?cliente_id=<?= $c->getId() ?>">
                        Editar
                    </a>
                    <button class="btn borrar"
                        onclick="deleteCliente(<?= $c->getId() ?>)">
                        Borrar
                    </button>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>
    <form action="" method="post" id="frmEliCli" name="frmEliCli" style="visibility: hidden;">
        <input type="hidden" name="idCliente" id="idCliente">
    </form>

        
</body>

</html>