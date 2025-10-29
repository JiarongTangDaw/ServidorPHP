<?php
    require_once 'datos.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenemos la acción del query string (URL)
        $accion = $_GET['action'] ?? '';

        // obtencion del año escrito en el formulario
        $anio = $_POST['anio'];
        
        // hacer global las variables de datos.php para poder usarlos
        global $Meses;
        global $diasSemana;

        // comprobar si el año es bisiesto o no
        if(($anio % 4)!= 0){
            $Meses[1]['dias'] = 28;
        }

        // numero del mes
        $numMes = 1;
        // imprime por pantalla el año
        echo "<h1> $anio </h1>";

        // recorreo los meses de la variable $Meses para obtener los dias de ese mes
        foreach($Meses as $mes){
            // variable para aguardar el dia de la semana del mes
            $diaSemana = "";
            // imprime nombre de mes
            echo "<h2>{$mes ['nombre']}</h2>";
            // for para recorrer los dias del mes para sacar su dia de la semana
            for ($i=1; $i <= ($mes ['dias']); $i++) { 
                // variable para guardar la fecha de forma numerica para la funcion de diaDeLaSemana
                $date = $anio.'-'.$numMes.'-'.$i;
                // sacamos el dia de la semana de la fecha enviada
                $diaSemana = diaDeLaSemana($date);
                // imprime la fecha completa
                echo "$diaSemana $i de {$mes['nombre']} de $anio <br>";
            }
            // incremento del numero de mes por que ha finalizado el contado de dias de el mes
            $numMes++;
        }

    }
?>