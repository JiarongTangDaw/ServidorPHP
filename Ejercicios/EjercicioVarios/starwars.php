<?php
    require_once 'datos.php';

    global $sw;

    $lista = $sw['results'];

    $nuevo = array_filter($lista, function ($nave){
        return (int) $nave['passengers'] > 100;
    });

    $listaFinal = array_map(function ($nave) {
        return ["nombre"=> $nave['name'], "modelo" => $nave['model']];
    },$nuevo);
    echo "<h1>PASAJERSO > 100 </h1><br>";
    print_r($listaFinal);

    $nuevo2 = array_filter($lista, function ($nave){
        return ((int) $nave['passengers'] <= 100 || $nave['passengers'] == "unknown");
    });

    $final = array_map(function ($nave) {
        return ["nombre"=> $nave['name'], "modelo" => $nave['model']];
    },$nuevo2);
    echo "<h1>PASAJERSO <= 100 </h1><br>";
    print_r($final);

    $tabla = "<table border = '1'> 
            <thead>
                <tr>
                    <th> Nave </th>
                    <th> Enlace Pelicula </th>
                </tr>
            </thead>
            <tbody>";
    foreach($lista as $nave){
        $tabla .= "<tr>
            <td>{$nave['name']}</td>
            <td>";
        foreach($nave['films'] as $peli){
            $tabla .= "$peli <br>";
        }
        $tabla .= "</td>
            </tr>";
    }
    $tabla .= " </tbody> </table>";

    echo $tabla;
?>