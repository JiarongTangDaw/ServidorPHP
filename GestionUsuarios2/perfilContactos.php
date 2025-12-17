<?php
    // Incluye utilidades y la clase Contacto
    require_once "./utils.php";
    require_once "./Contactos.php";

    // Por defecto, obtiene todos los contactos
    $listaContactos = Contacto::obtenerTodos($pdo);


    // Extrae el usuario conectado y su rol para control de permisos
    $rol_id_usuario = 0; // Rol por defecto
    if (isset($_SESSION["usuario"])) {
        $usu_conectado = $_SESSION["usuario"];
        $rol_id_usuario = $usu_conectado->getRolId();
    }

    // Comprueba si se ha pasado un ID de cliente para filtrar los contactos
    $idCliente = isset($_GET['idCliente'])? $_GET['idCliente'] : 0;

    // Si hay un ID de cliente (filtro), se obtiene la lista filtrada
    if($idCliente != 0){
        $listaContactos = Contacto::obtenerPorIdCliente($pdo,$idCliente);
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
    <title>Listado de Contactos</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="tabla-contenedor">
        <?php if (empty($listaContactos)): ?>
            <?php if ($idCliente != 0): ?>
                <h1>El cliente <?= $idCliente ?> no tiene contactos</h1>
                <button class="btn cerrarsesion" onclick="navegar('cliente')">Volver</button>
            <?php else: ?>
                <h1>No hay contactos registrados</h1>
                <button class="btn cerrarsesion" onclick="navegar('usuario')">Usuarios</button>
                <button class="btn cerrarsesion" onclick="navegar('cliente')">Clientes</button>
                <?php if ($rol_id_usuario == 1): ?>
                    <a href="./registrarContacto.php" class="btn primary anadir">➕ Añadir Contacto</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php else: ?>
            <h1>Listado de Contactos</h1>
            
            <?php if ($idCliente == 0): ?>
                <button class="btn cerrarsesion" onclick="navegar('usuario')">Usuarios</button>
                <button class="btn cerrarsesion" onclick="navegar('cliente')">Clientes</button>
                <?php if ($rol_id_usuario == 1): ?>
                    <a href="./registrarContacto.php" class="btn primary anadir">➕ Añadir Contacto</a>
                <?php endif; ?>
            <?php else: ?>
                <button class="btn cerrarsesion" onclick="navegar('cliente')">Volver a Clientes</button>
            <?php endif; ?>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <?php if ($rol_id_usuario == 1): ?>
                    <th>Acciones</th>
                    <?php endif; ?>
                </tr>

                <?php foreach ($listaContactos as $co): ?>
                <tr>
                    <td><?= $co->getId() ?></td>
                    <td><?= $co->getNombre() ?></td>
                    <td><?= $co->getApellidos() ?></td>
                    <td><?= $co->getEmail() ?></td>
                    <td><?= $co->getTelefono() ?></td>
                    </td>
                    <?php if ($rol_id_usuario == 1): ?>
                    <td class="acciones">
                        <a class="btn editar"
                            href="registrarContacto.php?contacto_id=<?= $co->getId() ?>">
                            Editar
                        </a>
                        <button class="btn borrar"
                            onclick="deleteContacto(<?= $co->getId() ?>)">
                            Borrar
                        </button>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>

            </table>
        <?php endif; ?>
    </div>
    <form action="" method="post" id="frmEliContacto" name="frmEliContacto" style="visibility: hidden;">
        <input type="hidden" name="idContacto" id="idContacto">
    </form>

        
</body>

</html>