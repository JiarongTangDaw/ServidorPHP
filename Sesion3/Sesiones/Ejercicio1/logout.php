<?php
session_start(); // Iniciar la sesión
session_destroy(); // Destruir la sesión
header("Location: login.php"); // Redirigir al login
exit();
?>