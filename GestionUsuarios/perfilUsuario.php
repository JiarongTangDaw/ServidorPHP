<?php
    // Incluye utilidades y la clase Usuario
    require_once "./utils.php";
    require_once "./Usuarios.php";

    // Obtiene todos los usuarios de la BD
    $listaUsuarios = Usuario::obtenerTodos($pdo);

    // Extrae el usuario conectado, su rol y su ID para control de permisos y autoprotección
    $rol_id_usuario = 0; // Rol por defecto
    $idUsuarioConectado = 0;
    if (isset($_SESSION["usuario"])) {
        $usu_conectado = $_SESSION["usuario"];
        $rol_id_usuario = $usu_conectado->getRolId();
        $idUsuarioConectado = $usu_conectado->getId();
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
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="tabla-contenedor">

        <h1>Listado de Usuarios</h1>
        <button class="btn cerrarsesion" onclick="cerrarSesion()">
            Cerrar Sesion
        </button>
        <button class="btn cerrarsesion" onclick="navegar('cliente')">
            Clientes
        </button>
        <button class="btn cerrarsesion" onclick="navegar('contacto')">
            Contactos
        </button>
        <?php if ($rol_id_usuario == 1): ?>
            <a href="./registrar.php?listado=true" class="btn primary anadir">➕ Añadir Usuario</a>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Rol</th>
                <?php if ($rol_id_usuario == 1): ?>
                <th>Acciones</th>
                <?php endif; ?>
            </tr>

            <?php foreach ($listaUsuarios as $u): ?>
            <tr>
                <td><?= $u->getId() ?></td>
                <td><?= $u->getUsuario() ?></td>
                <td><?= $u->getEmail() ?></td>
                <td><?= $u->getNombre() ?></td>
                <td><?= $u->getApellidos() ?></td>
                <td><?= $u->getRolId() == 1 ? 'Admin' : 'Usuario' ?>
                </td>
                <?php if ($rol_id_usuario == 1): ?>
                <td class="acciones">
                    <a class="btn editar"
                        href="modificar.php?usuario_id=<?= $u->getId() ?>&listado=true">
                        Editar
                    </a>
                    <?php if ($idUsuarioConectado !== $u->getId()): ?>
                    <button class="btn borrar"
                        onclick="deleteUsuario(<?= $u->getId() ?>)">
                        Borrar
                    </button>
                     <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>
    <form action="" method="post" id="frmEli" name="frmEli" style="visibility: hidden;">
        <input type="hidden" name="idUsuario" id="idUsuario">
    </form>

        
</body>

</html>