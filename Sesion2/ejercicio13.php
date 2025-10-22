<?php
    //forma antigua
    $frutas = array("Manzana", "Naranja", "Platano");
    // forma moderna
    $frutas2 = ["Manzana", "Naranja", "Platano"];

    //crear un array vacio y añadir elementos despues
    $colores = []; // o $colores = array();
    $colores[] = "Rojo"; // añade rojo en el indice 0
    $colores[] = "Verde"; // añade verde en el indice 1
    $colores[2] = "Azul"; // asigna azul explicitamente al indice 2
    $colores[] = "Amarillo"; // añade amarillo en el indice 3 (siguiente disponible)

    /* 
        Si nos saltamos una posicion del array, cuando se pide la lectura del valor
        en dicha posicion es null, por lo que no se puede leer
    */

    echo $frutas[0]; //manzana
    echo $colores[1]; //Verde
    echo $colores[0]; // rojo
    $colores[0] = "Morado"; //modifica un elemento
    echo $colores[0]; // morado

    $numeros = [10,20,30,40,50];
    echo "Recorriendo con for:<br>";
    for($i = 0; $i <count($numeros); $i++){
        echo "Indice $i: $numeros[$i] <br>";
    }

    echo "Recorriendo con foreach:<br>";
    foreach($numeros as $numero){
        echo "numero: $numero. > Algo...<br>";
    }
?>