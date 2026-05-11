<?php
    require_once './utils.php';
    require_once './Compatibilidad.php';

    $accion = $_GET['action'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $modelo1_id = isset($_POST['modelo1_id']) ? (int) $_POST['modelo1_id'] : 0;
        $modelo2_id = isset($_POST['modelo2_id']) ? (int) $_POST['modelo2_id'] : 0;
        $tipoaccesorio_id = isset($_POST['tipoaccesorio_id']) ? (int) $_POST['tipoaccesorio_id'] : 0;

        switch ($accion) {

            case 'addCompatibilidad':

                $error = validar();

                if ($error != '') {
                    header('Location: registrarCompatibilidad.php?error=' . $error);
                    exit();
                }

                $obj = new Compatibilidad();
                $obj->setModelo1Id($modelo1_id);
                $obj->setModelo2Id($modelo2_id);
                $obj->setTipoAccesorioId($tipoaccesorio_id);

                try {
                    $obj->guardar($pdo); // ya hace doble inserción con transacción
                } catch (PDOException $e) {
                    header('Location: registrarCompatibilidad.php?error=La compatibilidad ya existe o datos inválidos');
                    exit();
                }

                $mensaje = "Compatibilidad añadida correctamente";

                header('Location: panelAdmin.php?seccion=compatibilidades&mensaje=' . $mensaje);
                exit();

                break;
            
            case 'eliminar':

                $obj = new Compatibilidad();
                $obj->setModelo1Id($modelo1_id);
                $obj->setModelo2Id($modelo2_id);
                $obj->setTipoAccesorioId($tipoaccesorio_id);

                try {
                    $obj->eliminar($pdo); // elimina en ambas direcciones
                } catch (PDOException $e) {
                    header('Location: panelAdmin.php?seccion=compatibilidades&error=Error al eliminar la compatibilidad');
                    exit();
                }

                $mensaje = "Compatibilidad eliminada correctamente";

                header('Location: panelAdmin.php?seccion=compatibilidades&mensaje=' . $mensaje);
                exit();

                break;

            default:
                break;
        }
    }

    // ===== VALIDACIÓN =====

    function validar (){

        global $modelo1_id;
        global $modelo2_id;
        global $tipoaccesorio_id;

        $error = '';

        if ($modelo1_id == 0 || $modelo2_id == 0 || $tipoaccesorio_id == 0) {
            $error = 'Debe seleccionar todos los campos';
        }

        // Evitar compatibilidad consigo mismo
        if ($modelo1_id == $modelo2_id) {
            $error .= ' -- Un modelo no puede ser compatible consigo mismo';
        }

        return $error;
    }
?>