<?php
    require_once "./utils.php";

    $action = $_GET['action']??'';

    $error = $_GET['error'] ?? '';

    if($error != ''){
        echo "<script>alert('" . str_replace("--", "\\n", $error) . "')</script>";
    }
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Nuevo Usuario</title>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>Nuevo Usuario</h1>

        <form method="post" id= "formRegistrar">

            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" placeholder = "Nombre de usuario" required value="">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required value="">

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" required value="">

            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" value="">

            <?php
                if ($action != 'registrar'){
                    echo " <label for='rol'>Rol</label>
                            <select name='rol' id='rol'>
                                <option value ='1'selected> Admin</option>
                                <option value ='2'> Usuario</option>
                            </select>";
                }
            ?>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required value="">

            <button onclick="addUsuario(<?= $action ==  'registrar' ? 'false' : 'true'; ?>)">Crear Usuario</button>
        </form>
        <?php
            $variable = "usuario";
            if ($action == 'registrar'){
                echo "<p>Ya tengo una cuenta: <a href='./index.php'>Inicio</a></p>";
            }else{
                echo "<button class='cancelar' onclick=\"navegar('$variable')\">Cancelar</button>";
            }
        ?>
    </div>
</body>

</html>