<?php
    $titulo = "                         Informe Mensual                            ";
    $tope = "||";
    $ititulo = $tope.ltrim($titulo).$tope;
    $dtitulo = $tope.rtrim($titulo).$tope;
    $idtitulo = $tope.trim($titulo).$tope;

    echo "izquierda $ititulo<br>";
    echo "derecha $dtitulo <br>";
    echo "ambos $idtitulo<br>";

    $cadenaarr = "1,2,3,4";
    // se convierte en array la cadena de caracteres separado por coma
    $arrcadena = explode(",",$cadenaarr);

    echo $arrcadena[0],'<br>';

    // covierte en cadena el array separado por '||'
    $cadenaarr2 = implode("||",$arrcadena);
    echo $cadenaarr2;
?>