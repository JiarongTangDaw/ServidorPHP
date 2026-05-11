<?php
    require_once './utils.php';
    require_once './TipoAccesorio.php';

    $accion = $_GET['action'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $tipoaccesorio = $_POST['tipoaccesorio'] ?? '';
        // 🔥 Normalización
        $tipoaccesorio = ucfirst(strtolower(trim($tipoaccesorio)));

        $idTipoAccesorio = isset($_POST['idTipoAccesorio']) ? (int) $_POST['idTipoAccesorio'] : 0;
        
        switch ($accion) {

            case 'addTipoAccesorio':

                $error = validar();

                if ($error != '') {
                    header('Location: registrarTipoAccesorio.php?error=' . $error);
                    exit();
                }

                $obj = new TipoAccesorio();
                $obj->setTipoAccesorio($tipoaccesorio);

                try {
                    $obj->guardar($pdo);
                } catch (PDOException $e) {
                    header('Location: registrarTipoAccesorio.php?error=El tipo de accesorio ya existe');
                    exit();
                }

                $mensaje = "Tipo de accesorio añadido correctamente";

                header('Location: panelAdmin.php?seccion=tipoaccesorios&mensaje=' . $mensaje);
                exit();

                break;
            
            case 'modificar':

                $error = validar();

                if ($error != '') {
                    header('Location: registrarTipoAccesorio.php?tipoaccesorio_id=' . $idTipoAccesorio . '&error=' . $error);
                    exit();
                }

                $obj = TipoAccesorio::obtenerPorId($pdo, $idTipoAccesorio);
                $obj->setTipoAccesorio($tipoaccesorio);

                try {
                    $obj->guardar($pdo);
                } catch (PDOException $e) {
                    header('Location: registrarTipoAccesorio.php?tipoaccesorio_id=' . $idTipoAccesorio . '&error=El tipo de accesorio ya existe');
                    exit();
                }

                $mensaje = "Tipo de accesorio modificado correctamente";

                header('Location: panelAdmin.php?seccion=tipoaccesorios&mensaje=' . $mensaje);
                exit();

                break;

            case 'eliminar':

                $obj = TipoAccesorio::obtenerPorId($pdo, $idTipoAccesorio);

                try {
                    $obj->eliminar($pdo);
                } catch (PDOException $e) {
                    header('Location: panelAdmin.php?seccion=tipoaccesorios&error=No se puede eliminar (puede estar en uso)');
                    exit();
                }

                $mensaje = "Tipo de accesorio eliminado correctamente";

                header('Location: panelAdmin.php?seccion=tipoaccesorios&mensaje=' . $mensaje);
                exit();

                break;

            default:
                break;
        }
    }

    // ===== VALIDACIÓN =====

    function validar (){

        global $tipoaccesorio;

        $error = '';

        if ($tipoaccesorio == '') {
            $error = 'El campo tipo de accesorio no puede estar vacío';
        }

        return $error;
    }
?>