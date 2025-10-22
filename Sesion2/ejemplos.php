<?php
    $sCadena = "5";

    echo ($sCadena==5) . " caso 1<br>"; // compara valor pero no tipo
    echo ($sCadena===5) . "caso 2<br>"; // compara tanto el valor como el tipo

    // funciones
    function calcularPromedio(...$numeros): float {
        if (count($numeros) === 0) {
        return 0.0;
        }
        $suma = array_sum($numeros); return $suma /
        count($numeros);
    }
    echo "Promedio de 2, 4, 6: " . calcularPromedio(2, 4, 6) . "<br/>";// 4
    
    echo "Promedio de 10, 20, 30, 40, 50: " . calcularPromedio(10, 20, 30, 40, 50) . "<br/>"; // 30
    echo "Promedio sin números: " . calcularPromedio() . "<br/>";// 0

    function incrementarValor(int &$numero) { // El & indica paso por referencia
        $numero++;
        echo "Dentro de la función, número es: $numero <br/>"; 
    }
    $miNumero = 5;
    echo "Antes de llamar a la función, miNumero es: $miNumero <br/>"; // 5
    incrementarValor($miNumero);
    echo "Después de llamar a la función, miNumero es: $miNumero <br/>"; // 6(cambió)
?>