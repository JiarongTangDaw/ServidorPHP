<?php
require_once './setcookies.php'; // Incluir el archivo para establecer la cookie
// Iniciar la sesión
    session_start();
    
    //parte ejercicio 4
    $visita = incCookie(); // Llamar a la función para incrementar la cookie
    //fin parte ejercicio 4
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
</head>
<body>
    <?php
        if (isset($_SESSION['usuario'])) {// Verificar si el usuario está en la sesión
            echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['usuario']) . "!</h1>";// Mostrar mensaje de bienvenida


            //parte ejercicio 4
            echo "<p>Has visitado esta página " . $visita . " veces.</p>"; // Mostrar el número de visitas
            //fin parte ejercicio 4
            
            //parte ejercicio 3
            if (isset($_SESSION['login_time']) && time() - $_SESSION['login_time'] >= 60) {
                setcookie("visita", "", time() - 3600); // Eliminar la cookie
                session_destroy();
                // Si han pasado más de 60 segundos desde el inicio de sesión, redirigir al logout
                header("Location: login.php");
                exit();
            }
        } else {// Si no hay usuario en la sesión, mostrar mensaje alternativo
            echo "<p>No hay usuario logueado</p>";
        }
    ?>
    <!-- parte ejercicio 3 -->
     <!-- <script>
        setTimeout(function() {
            window.location.href = "logout.php";
        }, 60000); // Redirigir después de 1 minuto (60000 ms)
    </script> -->
    <!-- fin parte ejercicio 3 -->
</body>
</html>