<?php
    //cuando se usas $$var el contenido dentro de var lo trata como variable
    $nombreAnimal = "perro";
    $perro = "Fido"; 
    echo $$nombreAnimal; // Accede a $perro => “Fido”

    $saludo_en = "Hello";
    $saludo_es = "Hola";
    $saludo_fr = "Bonjour";
    $idioma = "fr";
    $nombreVariableSaludo = "saludo_" . $idioma; 
    echo $$nombreVariableSaludo . ",    Monde!"; // Bonjour, Monde!

?>