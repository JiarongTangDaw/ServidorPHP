<?php
// vamos a hacer un proceso recursivo que me sume los numeros de un array dado
// me tiene que valer cualquier array y de cualquier tipo elementos
function suma(array $array){
    $lengArray = count($array);
    if($lengArray == 1){
        return array_shift($array);
    }else{
        $resultado = array_shift($array);
        if(is_int($resultado) || is_float($resultado)){
            $resultado += suma($array);
        }else{
            $resultado =strval($resultado). " ".suma($array);
        };
    }
    return $resultado;
}

$lista = ["hola","como","estas"];
$lista2 = [1,2,3,4,5];
echo suma($lista)."<br>";
echo suma($lista2)."<br>";

function suma2(array $array, int &$contador = 0){
    $lengArray = count($array);
    if($contador == $lengArray - 1){
       return $array[$contador];
    }else{
        $resultado = $array[$contador];
        if(is_int($resultado) || is_float($resultado)){
            $contador++;
            $resultado += suma2($array);
        }else{
            $contador++;
            $resultado =strval($resultado). " ".suma2($array);
        };
    }
    return $resultado;
}
echo suma2($lista)."<br>";
echo suma2($lista2)."<br>";
?>