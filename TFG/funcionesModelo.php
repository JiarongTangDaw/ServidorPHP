<?php
    require_once './utils.php';
    require_once './Modelo.php';

    $accion = $_GET['action'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $modelo = $_POST['modelo'] ?? '';
        // 🔥 Normalización
        $modelo = ucfirst(strtolower(trim($modelo)));

        $marca_id = isset($_POST['marca_id']) ? (int) $_POST['marca_id'] : 0;
        $idModelo = isset($_POST['idModelo']) ? (int) $_POST['idModelo'] : 0;
        
        switch ($accion) {

            case 'addModelo':

                $error = validar();

                if ($error != '') {
                    header('Location: registrarModelo.php?error=' . $error);
                    exit();
                }

                $obj = new Modelo();
                $obj->setModelo($modelo);
                $obj->setMarcaId($marca_id);

                try {
                    $obj->guardar($pdo);
                } catch (PDOException $e) {
                    header('Location: registrarModelo.php?error=El modelo ya existe para esa marca o marca inválida');
                    exit();
                }

                $mensaje = "Modelo añadido correctamente";

                header('Location: panelAdmin.php?seccion=modelos&mensaje=' . $mensaje);
                exit();

                break;
            
            case 'modificar':

                $error = validar();

                if ($error != '') {
                    header('Location: registrarModelo.php?modelo_id=' . $idModelo . '&error=' . $error);
                    exit();
                }

                $obj = Modelo::obtenerPorId($pdo, $idModelo);
                $obj->setModelo($modelo);
                $obj->setMarcaId($marca_id);

                try {
                    $obj->guardar($pdo);
                } catch (PDOException $e) {
                    header('Location: registrarModelo.php?modelo_id=' . $idModelo . '&error=El modelo ya existe para esa marca');
                    exit();
                }

                $mensaje = "Modelo modificado correctamente";

                header('Location: panelAdmin.php?seccion=modelos&mensaje=' . $mensaje);
                exit();

                break;

            case 'eliminar':

                $obj = Modelo::obtenerPorId($pdo, $idModelo);

                try {
                    $obj->eliminar($pdo);
                } catch (PDOException $e) {
                    header('Location: panelAdmin.php?seccion=modelos&error=No se puede eliminar (puede estar en uso)');
                    exit();
                }

                $mensaje = "Modelo eliminado correctamente";

                header('Location: panelAdmin.php?seccion=modelos&mensaje=' . $mensaje);
                exit();

                break;

            default:
                break;
        }
    }

    // ===== VALIDACIÓN =====

    function validar (){

        global $modelo;
        global $marca_id;

        $error = '';

        if ($modelo == '' || $marca_id == 0) {
            $error = 'Debe rellenar todos los campos';
        }

        return $error;
    }
?>