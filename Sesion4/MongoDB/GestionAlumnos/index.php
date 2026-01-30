<?php
    require_once __DIR__ . '/utils.php';
    global $datos;
    global $arrayFilaAlumnos;
    
    // Mostrar alertas si hay mensajes de error o éxito
    $error = $_GET['error'] ?? '';
    if($error != ''){
        echo "<script>alert('$error');</script>";
    }
    $mensaje = $_GET['mensaje'] ?? '';
    if($mensaje != ''){
        echo "<script>alert('$mensaje');</script>";
    }

    // Obtener los números de fila únicos para el selector
    $numFilas = [];
    foreach ($datos as $fila) {
        if (!in_array($fila->numero, $numFilas)) {
            $numFilas[] = $fila->numero;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de alumnos</title>
    <link rel="stylesheet" href="style.css">
    <script src="funciones.js" defer></script>
</head>
<body>
    <h1>Gestor de Alumnos</h1>
    <form action="funciones.php" id="formulario" name="formulario" method="post">
        <input type="hidden" name="apellidosNew" id="apellidosNew">
        <input type="hidden" name="apellidosOld" id="apellidosOld">
        <input type="hidden" name="nombre" id="nombre">
        <input type="hidden" name="numFilaNew" id="numFilaNew">
        <input type="hidden" name="numFilaOld" id="numFilaOld">
        <input type="hidden" name="esProfeSexy" id="esProfeSexy">
        <input type="hidden" name="sexo" id="sexo">
        <?php
            if(count($arrayFilaAlumnos) == 0){
        ?>
        <p>No hay alumnos en la base de datos</p>
        <button type="button" onclick="importarDatos()" >Importar datos</button>
        
        <?php
            } else {
        ?>
        <div id="principal">
            
            <!-- Fila en donde se encontrara los campos a rellenar para un nuevo comic -->
            <div id="nuevo">
                <h2>Nuevo Alumno</h2>
                <label for="numFila0">Número de Fila</label> 
                <select id="numFila0">
                    <option value=''></option>
                    <?php foreach($numFilas as $numFila): ?>
                        <option value="<?= $numFila ?>"><?= $numFila ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="nombre0">Nombre</label>
                <input type="text" id="nombre0" value="">
                <label for="apellidos0">Apellidos</label>
                <input type="text" id="apellidos0" value="">
                <label for="sexo0">Sexo</label>
                <select id="sexo0">
                    <option value=''></option>
                    <option value='H'>Hombre</option>
                    <option value='M'>Mujer</option>
                </select>
                 <label for="esProfeSexy0">Es Profe Sexy</label> 
                <select id="esProfeSexy0">
                    <option value=''></option>
                    <option value='1'>Sí</option>
                    <option value='0'>No</option>
                </select>
                <!-- boton para añadir el comic nuevo -->
                <div class="botones">
                    <input type="button" id="btAdd" onclick="agregar();" value="NUEVO">
                </div>
            </div><!-- cabecera para la tabla de lista de comics -->
            <div id="cabecera">             
                <p>Fila</p>
                <p>Nombre</p>
                <p>Apellidos</p>
                <p>Sexo</p>
                <p>Es Profe Sexy</p>
                <p>Botones</p>
            </div>
            <!-- listado de los comics que tenemos -->
            <div id="listado">
                <?php
                    foreach($arrayFilaAlumnos as $fila){
                        $arrayAlumnos = $fila -> getAlumnos();
                        $num = $fila -> getNumero();
                        foreach($arrayAlumnos as $alumno){
                            $apellido = str_replace(' ','_',$alumno -> getApellidos());
                ?>
                <select name="numFila<?= $apellido ?>" id="numFila<?= $apellido ?>">
                <?php foreach($numFilas as $numFila): ?>
                    <option value="<?= $numFila ?>" <?= $numFila == $num ? 'selected' : '' ?>><?= $numFila?></option>
                <?php endforeach; ?>
                </select>
                <input type="text" name="nombre<?= $apellido ?>" id="nombre<?= $apellido ?>" value="<?= $alumno -> nombre ?>">
                <input type="text" name="apellidos<?= $apellido ?>" id="apellidos<?= $apellido ?>" value="<?= $alumno -> apellidos ?>">
                <select name="sexo<?= $apellido ?>" id="sexo<?= $apellido ?>">
                    <option value='H' <?= $alumno -> sexo == 'H' ? 'selected' : '' ?>>Hombre</option>
                    <option value='M' <?= $alumno -> sexo == 'M' ? 'selected' : '' ?>>Mujer</option>
                </select>
                <select name="esProfeSexy<?= $apellido ?>" id="esProfeSexy<?= $apellido ?>">
                    <option value='1' <?= $alumno -> es_profe_sexy == true ? 'selected' : '' ?>>Sí</option>
                    <option value='0' <?= $alumno -> es_profe_sexy == false ? 'selected' : '' ?>>No</option>
                </select>
                <!-- campo con botones de eliminar y modificar para modificar y eliminar comic, por el cual se le pasa el id del comic al que seleccionamos -->
                <div class="botones">
                    <input type="button" value="MOD" onclick= "modificar('<?= $alumno -> getApellidos() ?>', '<?=$num?>');">
                    <input type="button" value="DEL" onclick= "eliminar('<?= $alumno -> getApellidos() ?>', '<?=$num?>');">
                </div>
                <?php
                        }}
                ?>
            </div>
        </div>
        <?php    
            }
        ?>
    </form>
</body>
</html>