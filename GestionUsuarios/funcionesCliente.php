<?php
    // Incluye las utilidades básicas (PDO, validaciones, sesión, etc.)
    require_once './utils.php';
    // Incluye la clase Cliente para las operaciones de negocio
    require_once './Clientes.php';

    // Obtenemos la acción del query string (addCliente, modificar, eliminar)
    $accion = $_GET['action'] ?? '';

    // Solo procesamos si el método de envío es POST (desde el formulario)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Recogida y sanitización de datos del formulario POST
        $email =  isset($_POST['email']) ? $_POST['email'] : '';
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
        $cif = isset($_POST['cif']) ? $_POST['cif'] : '';
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
        $edad = isset($_POST['edad']) ? (int) $_POST['edad'] : 0;
        // El contacto puede ser 0 si no se selecciona ninguno
        $contacto = isset($_POST['contacto']) ? (int) $_POST['contacto'] : 0;
        // idCliente es necesario para modificar o eliminar
        $idCliente = isset($_POST['idCliente']) ? (int) $_POST['idCliente'] : 0;
        
        switch ($accion) {
            case 'addCliente':

                // 1. Validar los datos
                $error = validar();

                if($error != ''){
                    // Si hay error, redirigir al formulario con el mensaje de error
                    header('Location: registrarCliente.php?error=' . $error);
                    exit();
                }

                // 2. Crear un nuevo objeto Cliente e inyectar los datos
                $cliente = new Cliente();
                $cliente->setNombre($nombre);
                $cliente->setApellidos($apellidos);
                $cliente->setEmail($email);
                $cliente->setCIF($cif);
                $cliente->setTelefono($telefono);
                $cliente->setEdad($edad);
                
                // Si se seleccionó un contacto, establecer su ID
                if($contacto != 0){
                    $cliente->setContactoId($contacto);
                }

                // 3. Guardar el nuevo cliente en la base de datos
                $cliente->guardar($pdo);

                $mensaje = "Nuevo Cliente añadido correctamente";

                // Redirigir al listado con un mensaje de éxito
                header('Location: perfilClientes.php?mensaje=' . $mensaje);
                exit();

                break;
            
            case 'modificar':
                // 1. Validar los datos actualizados
                $error = validar();

                if($error != ''){
                    // Si hay error, redirigir al formulario de modificación con el error
                    header('Location: registrarCliente.php?cliente_id=' . $idCliente . '&error=' . $error );
                    exit();
                }

                // 2. Obtener el cliente existente de la BD
                $cliente = Cliente::obtenerPorId($pdo, $idCliente);
                
                // 3. Actualizar sus propiedades
                $cliente->setNombre($nombre);
                $cliente->setApellidos($apellidos);
                $cliente->setEmail($email);
                $cliente->setCIF($cif);
                $cliente->setTelefono($telefono);
                $cliente->setEdad($edad);

                // Si se seleccionó un contacto, establecer el ID (podría ser 0 para desvincular)
                $cliente->setContactoId($contacto);

                // 4. Guardar los cambios (la función guardar detecta que es un UPDATE)
                $cliente->guardar($pdo);

                $mensaje = "Cliente modificado correctamente";

                header('Location: perfilClientes.php?mensaje=' . $mensaje );
                exit();
                break;

            case 'eliminar':
                // 1. Obtener el cliente por ID
                $cliente = Cliente::obtenerPorId($pdo,$idCliente);
                // 2. Eliminar de la base de datos
                $cliente->eliminar($pdo);
                $mensaje = "Cliente " . $cliente->getId() . " eliminado correctamente";
                // 3. Redirigir al listado
                header('Location: perfilClientes.php?mensaje=' . $mensaje);
                exit();
                break;
            default:
                // Si la acción no es reconocida, no hacer nada
                break;
        }

    }

    /**
     * Función interna para validar los campos del formulario de cliente.
     * Retorna un string de errores separados por '--' o un string vacío.
     */
    function validar (){

        global $nombre;
        global $apellidos;
        global $email;
        global $telefono;
        global $cif;
        global $edad;

        $error = '';

        // Comprobación de campos obligatorios
        if ($nombre == '' || $apellidos == '' || $email == '' || $telefono == '' || $cif == '' || $edad == 0) {
            $error = 'NO puede haber campos vacios';
        }else{
            // Validación de formatos con funciones de utils.php
            if (!comprobarPatronEmail($email)) {
                $error .= 'Formato de Email incorrecto--';
            }
            if (!comprobarTelefono($telefono)) {
                $error .= 'Formato de telefono incorrecto--';
            }
            if (!comprobarEdad($edad)) {
                $error .= 'Rango de edad introducido incorrecto--';
            }
            if (!comprobarDocumento($cif)) {
                $error .= 'Formato de CIF incorrecto--';
            }
        }

        return $error;
    }
?>