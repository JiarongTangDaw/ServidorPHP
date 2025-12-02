<?php
    session_start();
    require_once './utils.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['usernameRegistro']??"";
        $password = $_POST['passwordRegistro']??"";

        if($username == "" || $password == ""){
           $_SESSION['error'] = 'NO PUEDE HABER CAMPOS VACIOS';
        }else{
            $valido = validarUsername($username);
            if(!$valido){
                $_SESSION['error'] = 'Nombre de usuario no valido';
            }else{
                $existeUsuario = existeUsuario($username);
                if($existeUsuario){
                    $_SESSION['error'] = 'Ya existe un usuario con este nombre';
                }else{
                    $exito = addUsuario($username,$password);
                    if($exito){
                        $_SESSION['mensaje'] = 'Usuario añadido con exito';
                    }else{
                        $_SESSION['error'] = 'Usuario no se ha podido añadir';
                    }
                    header("Location: index.php");
                    exit();
                }
            }
        }
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
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Crear cuenta</h2>
    <form action="./register.php" method="post">

        <label for="username">Nombre usuario:</label>
        <input type="text" name="usernameRegistro" id="username">
        <label for="password">Contraseña:</label>
        <input type="password" name="passwordRegistro" id="password">
        <input type="submit" value="Crear cuenta">
        <p>Ya tienes cuenta: <a href="./index.php">Login</a></p>
    </form>
</body>
</html>

<?php
    
?>