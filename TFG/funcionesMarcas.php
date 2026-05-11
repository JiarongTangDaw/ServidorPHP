<?php
    require_once './utils.php';
    require_once './Marca.php';

    $accion = $_GET['action'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $marca = $_POST['marca'] ?? '';
        // 🔥 Normalización: primera letra mayúscula, resto minúsculas + quitar espacios
        $marca = ucfirst(strtolower(trim($marca)));

        $idMarca = isset($_POST['idMarca']) ? (int) $_POST['idMarca'] : 0;
        
        switch ($accion) {

            case 'addMarca':

                $error = validar();

                if ($error != '') {
                    header('Location: registrarMarca.php?error=' . $error);
                    exit();
                }

                $marcaObj = new Marca();
                $marcaObj->setMarca($marca);

                try {
                    $marcaObj->guardar($pdo);
                } catch (PDOException $e) {
                    header('Location: registrarMarca.php?error=La marca ya existe');
                    exit();
                }

                $mensaje = "Marca añadida correctamente";

                header('Location: panelAdmin.php?seccion=marcas&mensaje=' . $mensaje);
                exit();

                break;
            
            case 'modificar':

                $error = validar();

                if ($error != '') {
                    header('Location: registrarMarca.php?marca_id=' . $idMarca . '&error=' . $error);
                    exit();
                }

                $marcaObj = Marca::obtenerPorId($pdo, $idMarca);
                $marcaObj->setMarca($marca);

                try {
                    $marcaObj->guardar($pdo);
                } catch (PDOException $e) {
                    header('Location: registrarMarca.php?marca_id=' . $idMarca . '&error=La marca ya existe');
                    exit();
                }

                $mensaje = "Marca modificada correctamente";

                header('Location: panelAdmin.php?seccion=marcas&mensaje=' . $mensaje);
                exit();

                break;

            case 'eliminar':

                $marcaObj = Marca::obtenerPorId($pdo, $idMarca);

                try {
                    $marcaObj->eliminar($pdo);
                } catch (PDOException $e) {
                    header('Location: panelAdmin.php?seccion=marcas&error=No se puede eliminar la marca (puede estar en uso)');
                    exit();
                }

                $mensaje = "Marca eliminada correctamente";

                header('Location: panelAdmin.php?seccion=marcas&mensaje=' . $mensaje);
                exit();

                break;

            default:
                break;
        }
    }

    // ===== VALIDACIÓN =====

    function validar (){

        global $marca;

        $error = '';

        if ($marca == '') {
            $error = 'El campo marca no puede estar vacío';
        }

        return $error;
    }
?>