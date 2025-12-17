<?php
// Incluir archivos necesarios para el funcionamiento del código
require_once "./utils.php";      // Funciones de utilidad general
require_once './Usuarios.php';   // Clase Usuario y sus métodos

// Obtener el ID del usuario desde los parámetros GET, con valor por defecto 0
$usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : 0;

// Obtener parámetro 'listado' para determinar si se muestra en modo listado
// Se convierte a booleano (true/false) usando (boolean)
$listado = isset($_GET['listado']) ? (boolean)$_GET['listado'] : false;

// Si se proporcionó un ID de usuario válido (diferente de 0), obtener sus datos
if($usuario_id != 0) {
    $user = Usuario::obtenerPorId($pdo, $usuario_id);
}

// Verificar si hay un usuario en la sesión (usuario conectado)
if (isset($_SESSION["usuario"])) {
    $usu_conectado = $_SESSION["usuario"];              // Obtener objeto usuario de la sesión
    $idUsuarioConectado = $usu_conectado->getId();     // Obtener ID del usuario conectado
}

// Asegurar que $user tenga un valor (obtiene usuario o crea uno nuevo vacío)
// Operador de fusión null (??) evita error si obtenerPorId() retorna null
$user = Usuario::obtenerPorId($pdo, $usuario_id) ?? new Usuario();

// Obtener mensaje de error desde parámetros GET (si existe)
$error = $_GET['error'] ?? '';  // Valor por defecto: cadena vacía

// Si hay un mensaje de error, mostrarlo como alerta JavaScript
if($error != ''){
    // Reemplazar '--' por saltos de línea (\n) para formato en alerta
    // Escapar comillas simples para JavaScript
    echo "<script>alert('" . str_replace("--", "\\n", $error) . "')</script>";
}
?>

<!doctype html>
<html lang="es">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    
    <!-- Título dinámico según si es creación o modificación de usuario -->
    <?php if ($usuario_id == 0):?>
        <title>Nuevo Usuario</title>
    <?php else:?>
        <title>Modificar Usuario</title>
    <?php endif;?>
    
    <!-- Enlaces a archivos de estilos y scripts -->
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        
        <!-- Título principal dinámico (igual que en el head) -->
        <?php if ($usuario_id == 0):?>
            <h1>Nuevo Usuario</h1>
        <?php else:?>
            <h1>Modificar Usuario</h1>
        <?php endif;?>

        <!-- Formulario principal para crear/modificar usuario -->
        <!-- No tiene acción definida, se manejará mediante JavaScript -->
        <form method="post" id="formRegistrar">
            
            <!-- Campo oculto para ID del usuario (se llenará dinámicamente) -->
            <input type="hidden" name="idUsuario" id="idUsuario">
            
            <!-- Campo: Nombre de usuario -->
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario" required 
                   value="<?= htmlspecialchars($user->getUsuario()) ?>">
            
            <!-- Campo: Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required 
                   value="<?= htmlspecialchars($user->getEmail()) ?>">
            
            <!-- Campo: Nombre -->
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" required 
                   value="<?= htmlspecialchars($user->getNombre()) ?>">
            
            <!-- Campo: Apellidos -->
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" 
                   value="<?= htmlspecialchars($user->getApellidos()) ?>">
            
            <!-- Campo: Contraseña (solo se muestra para nuevo usuario) -->
            <?php if ($usuario_id == 0):?>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" 
                       <?= $usuario_id === 0 ? 'required' : '' ?> value="">
            <?php endif;?>
            
            <!-- Campo: Rol (solo para modificación, no para creación) -->
            <?php if ($usuario_id != 0):?>
                <label for='rol'>Rol</label>
                <select name='rol' id='rol'>
                    <option value='1' <?= $user->getRolId() === 1 ? 'selected' : '' ?>>Admin</option>
                    <option value='2' <?= $user->getRolId() === 2 ? 'selected' : '' ?>>Usuario</option>
                </select>
            <?php endif;?>
            
            <!-- Botones de acción (crear o modificar según el contexto) -->
            <?php if ($usuario_id != 0):?>
                <!-- Botón para modificar usuario existente -->
                <button type='button' onclick="modUsuario(<?= $user->getId() ?>)">Modificar Usuario</button>
            <?php else:?>
                <!-- Botón para crear nuevo usuario -->
                <!-- Se pasa parámetro booleano para redireccionar a listado o no -->
                <button type='button' onclick="addUsuario(<?= $listado ? 'true' : 'false' ?>)">Crear Usuario</button>
            <?php endif;?>
            
        </form>
        
        <!-- Enlaces de navegación adicionales -->
        <?php if ($usuario_id != 0):?>
            <!-- Botón para cancelar modificación (vuelve a la lista de usuarios) -->
            <button class='cancelar' onclick="navegar('usuario')">Cancelar</button>
        <?php else:?>
            <!-- Enlace para usuarios que ya tienen cuenta (solo en creación) -->
            <p>Ya tengo una cuenta: <a href='./index.php'>Inicio</a></p>
        <?php endif;?>
       
    </div>
</body>

</html>