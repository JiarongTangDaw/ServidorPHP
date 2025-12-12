<?php
    $actual = getcwd();
    $superior = dirname($actual,1);
    
    $lista = scandir($superior);

    foreach($lista as $archivo){
        $rutaCompleta = $superior . '/' . $archivo;
        if(is_file($rutaCompleta )){
           $info = pathinfo($archivo);
           if($info['extension'] == 'txt'){
                echo "Archivo: " . $archivo ."<br>";
           }
        }
    }
?>