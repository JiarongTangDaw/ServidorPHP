<?php
    // Incluye las utilidades básicas (PDO, validaciones, sesión, etc.)
    require_once './utils.php';
    // Incluye la clase Contacto para las operaciones de negocio
    require_once './Contactos.php';

    // Obtenemos la acción del query string (addContacto, modificar, eliminar)
    $accion = $_GET['action'] ?? '';

    // Solo procesamos si el método de envío es POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Recogida y sanitización de datos del formulario POST
        $email =  isset($_POST['email']) ? $_POST['email'] : '';
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
        // idContacto es necesario para modificar o eliminar
        $idContacto = isset($_POST['idContacto']) ? (int) $_POST['idContacto'] : 0;
        
        switch ($accion) {
            case 'addContacto':

                // 1. Validar los datos
                $error = validar();

                if($error != ''){
                    // Si hay error, redirigir al formulario con el mensaje de error
                    header('Location: registrarContacto.php?error=' . $error );
                    exit();
                }

                // 2. Crear nuevo objeto Contacto
                $contacto = new Contacto();
                $contacto->setNombre($nombre);
                $contacto->setApellidos($apellidos);
                $contacto->setEmail($email);
                $contacto->setTelefono($telefono);
                
                // 3. Guardar el nuevo contacto
                $contacto->guardar($pdo);

                $mensaje = "Nuevo Contacto añadido correctamente";

                // Redirigir al listado con mensaje de éxito
                header('Location: perfilContactos.php?mensaje=' . $mensaje);
                exit();

                break;
            
            case 'modificar':
                // 1. Validar los datos
                $error = validar();

                if($error != ''){
                    // Si hay error, redirigir al formulario de modificación con el error
                    header('Location: registrarContacto.php?contacto_id=' . $idContacto . '&error=' . $error );
                    exit();
                }

                // 2. Obtener el contacto existente de la BD
                $contacto = Contacto::obtenerPorId($pdo, $idContacto);
                
                // 3. Actualizar sus propiedades
                $contacto->setNombre($nombre);
                $contacto->setApellidos($apellidos);
                $contacto->setEmail($email);
                $contacto->setTelefono($telefono);

                // 4. Guardar los cambios (la función guardar detecta que es un UPDATE)
                $contacto->guardar($pdo);

                $mensaje = "Contacto modificado correctamente";

                header('Location: perfilContactos.php?mensaje=' . $mensaje);
                exit();
                break;

            case 'eliminar':
                // 1. Obtener el contacto por ID
                $contacto = Contacto::obtenerPorId($pdo,$idContacto);
                // 2. Eliminar de la base de datos
                $contacto->eliminar($pdo);
                $mensaje = "Contacto " . $contacto->getId() . " eliminado correctamente";
                // 3. Redirigir al listado
                header('Location: perfilContactos.php?mensaje=' . $mensaje);
                exit();
                break;
            default:
                break;
        }

    }

    /**
     * Función interna para validar los campos del formulario de contacto.
     * Retorna un string de errores separados por '--' o un string vacío.
     */
    function validar (){

        global $nombre;
        global $apellidos;
        global $email;
        global $telefono;

        $error = '';

        // Comprobación de campos obligatorios
        if ($nombre == '' || $apellidos == '' || $email == '' || $telefono == '' ) {
            $error = 'NO puede haber campos vacios';
        }else{
            // Validación de formatos con funciones de utils.php
            if (!comprobarPatronEmail($email)) {
                $error .= 'Formato de Email incorrecto--';
            }
            if (!comprobarTelefono($telefono)) {
                $error .= 'Formato de telefono incorrecto--';
            }
        }

        return $error;
    }
?>