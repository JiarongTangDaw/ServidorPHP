<?php
    require_once 'datos.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenemos la acción del query string (URL)
        $accion = $_GET['action'] ?? '';

        $anio = $_POST['anio'];
        
        global $Meses;
        global $diasSemana;

        if(($anio % 4)!= 0){
            $Meses[1]['dias'] = 28;
        }

        $numMes = 1;
        echo "<h1> $anio </h1>";

        foreach($Meses as $mes){
            $diaSemana = "";
            echo "<h2>{$mes ['nombre']}</h2>";
            for ($i=1; $i <= ($mes ['dias']); $i++) { 
                $date = $anio.'-'.$numMes.'-'.$i;
                $diaSemana = diaDeLaSemana($date);
                echo "$diaSemana $i de {$mes['nombre']} de $anio <br>";
            }
            $numMes++;
        }
        

    }
?>