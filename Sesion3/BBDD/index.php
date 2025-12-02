<?php
    require_once './utils.php';
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username']??"";
        $password = $_POST['password']??"";

        if($username == "" || $password == ""){
            $_SESSION['error'] = 'NO PUEDE HABER CAMPOS VACIOS';
        }else{
            $valido = validarUsername($username);
            $password = sanetizar($password);
            if(!$valido){
                $_SESSION['error'] = 'Nombre de usuario no valido';
            }else{
                $existeUsuario = existeUsuario($username);
                if(!$existeUsuario){
                    $_SESSION['error'] = 'No existe usuario con este nombre';
                }else{
                    $passBBDD = buscarPassUsuario($username);
                    if(!($password == descifrar($passBBDD))){
                        $_SESSION['error'] = 'Contraseña incorrecta';
                    }else{
                        $_SESSION['username'] = $username;
                        header("Location: profile.php");
                        exit();
                    }
                }
            }
        }
    }


    if(isset($_SESSION['mensaje'])){
        echo "<script>
                    alert('".$_SESSION['mensaje']."')
                    </script>";
        unset($_SESSION['mensaje']);
    }

    if(isset($_SESSION['error'])){
        echo "<script>
                    alert('".$_SESSION['error']."')
                    </script>";
        unset($_SESSION['error']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <form action="./index.php" method="post">

        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Iniciar Sesion">
        <p>No tienes cuenta: <a href="./register.php">Crea una cuenta</a></p>
    </form>
</body>
</html>
