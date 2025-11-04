<?php
    require_once 'datos.php';

    global $sw;
    // copia de array de naves de sw
    $lista = $sw['results'];
    // sacar array filtrado con pasajeros > 100
    $nuevo = array_filter($lista, function ($nave){
        return (int) $nave['passengers'] > 100;
    });
    // mapear el array nuevo sacando solo nombre y modelo
    $listaFinal = array_map(function ($nave) {
        return ["nombre"=> $nave['name'], "modelo" => $nave['model']];
    },$nuevo);
    // mostra por pantalla
    echo "<h1>PASAJERSO > 100 </h1><br>";
    print_r($listaFinal);

    // sacar array filtrado por pasajeros <= 100 o unkwon
    $nuevo2 = array_filter($lista, function ($nave){
        return ((int) $nave['passengers'] <= 100 || $nave['passengers'] == "unknown");
    });
    // mapear el array nuevo2 sacando solo nombre y modelo
    $final = array_map(function ($nave) {
        return ["nombre"=> $nave['name'], "modelo" => $nave['model']];
    },$nuevo2);
    // mostrar por pantalla
    echo "<h1>PASAJERSO <= 100 </h1><br>";
    print_r($final);

    // table para nave y enlace peli donde aparece
    $tabla = "<table border = '1'> 
            <thead>
                <tr>
                    <th> Nave </th>
                    <th> Enlace Pelicula </th>
                </tr>
            </thead>
            <tbody>";
    // recorremos el array para sacar el nombre de la nave y los enlaces
    foreach($lista as $nave){
        $tabla .= "<tr>
            <td>{$nave['name']}</td>
            <td>";
        foreach($nave['films'] as $peli){ // por cada enlace la añadimos a la tabla
            $tabla .= "$peli <br>";
        }
        $tabla .= "</td>
            </tr>";
    }
    $tabla .= " </tbody> </table>";
    //imprimir tabla
    echo $tabla;
?>