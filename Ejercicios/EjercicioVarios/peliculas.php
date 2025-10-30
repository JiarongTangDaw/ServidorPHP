<?php
    require_once 'datos.php';

    function mostrar($lista){
        foreach($lista as $elem){
            echo "$elem <br>";
        }
    }

    function mostrar2($lista){
        foreach($lista as $elem){
            print_r($elem);
            echo "<br>";
        }
    }

    global $movieTitles;

    echo "<h1> MOVIE TITLE </h1>";
    echo "<h2> LISTA ANTES DE ORDENAR </h2>";
    mostrar($movieTitles);

    echo "<h2> LISTA DESPUES DE ORDENAR </h2>";
    $copia = unserialize(serialize($movieTitles));
    sort($copia);
    mostrar($copia);
    echo "<h3> Original </h3><br>";
    mostrar($movieTitles);

    echo "<h2> LISTA DE 11 A 15 </h2><br>";
    $movieCopia = array_slice($movieTitles,10,5);
    mostrar($movieCopia);
    echo "<h3> Original </h3><br>";
    mostrar($movieTitles);

    echo "<h2> Mi lista de peliculas </h2><br>";
    $miLista = unserialize(serialize($movieTitles));

    array_splice($miLista,0,1,"NeZha");
    array_splice($miLista,4,1,"El castillo ambulante");
    array_splice($miLista,16,1,"El viaje de Chihiro");
    mostrar($miLista);
    echo "<h3> Original </h3><br>";
    mostrar($movieTitles);

    echo "<h2> Añadido a mi lista mi pelicula favorita </h2><br>";
    array_unshift($miLista,"Pokemon: Arceus y la joya de la vida");
    mostrar($miLista);
    echo "<h3> Original </h3><br>";
    mostrar($movieTitles);

    echo "<h2> Añadido a mi lista una peli al final </h2><br>";
    array_push($miLista,"Pokemon 4ever: Celebi - Voces del bosque");
    mostrar($miLista);
    echo "<h3> Original </h3><br>";
    mostrar($movieTitles);
    
    global $bestMovies;

    echo "<h1> BEST MOVIES </h1><br>";
    echo "<h2> LISTA ANTES DE ORDENAR </h2><br>";
    mostrar2($bestMovies);

    echo "<h2> LISTA DESPUES DE ORDENAR </h2><br>";
    $copia2 = unserialize(serialize($bestMovies));
    usort($bestMovies,function($a,$b){
        return $a['title']  <=> $b['title'];
    });
    mostrar2($copia2);
    echo "<h3> Original </h3><br>";
    mostrar2($bestMovies);

    echo "<h2> LISTA DE 11 A 15 </h2><br>";
    $bestCopia = array_slice($bestMovies,10,5);
    mostrar2($bestCopia);
    echo "<h3> Original </h3><br>";
    mostrar2($bestMovies);

    echo "<h2> Mi lista de peliculas </h2><br>";
    $miLista2 = unserialize(serialize($bestMovies));

    array_splice($miLista2,0,1,[["title" => "NeZha", "director" => "Jiaozi", "actor" => "Griffin Puatu"]]);
    array_splice($miLista2,4,1,[["title" => "El castillo ambulante", "director" => "Hayao Miyazaki", "actor" => "Chieko Baisho"]]);
    array_splice($miLista2,16,1,[["title" => "El viaje de Chihiro", "director" => "Hayao Miyazaki", "actor" => "Rumi Hiiragi"]]);
    mostrar2($miLista2);
    echo "<h3> Original </h3><br>";
    mostrar2($bestMovies);

    echo "<h2> Añadido a mi lista mi pelicula favorita </h2><br>";
    array_unshift($miLista2,[["title" => "Pokemon: Arceus y la joya de la vida", "director" => "Kunihiko Yuyama", "actor" => "Ikue Ōtani"]]);
    mostrar2($miLista2);
    echo "<h3> Original </h3><br>";
    mostrar2($bestMovies);

    echo "<h2> Añadido a mi lista una peli al final </h2><br>";
    array_push($miLista2,[["title" => "Pokemon 4ever: Celebi - Voces del bosque", "director" => "Kunihiko Yuyama", "actor" => "Veronica Taylor"]]);
    mostrar2($miLista2);
    echo "<h3> Original </h3><br>";
    mostrar2($bestMovies);

    echo "<h2> ARRAY DE OBJETOS </h2><br>";
    $listaObj = [];
    foreach($bestMovies as $peli){
        $array = [];
        echo count($listaObj);
        if(count($listaObj) == 0){
            $array['director'] = $peli['director'];
            $array['Numero_veces_aparece'] = 1;
            if($peli['director'] == "Christopher Nolan"){
                $array['pesado'] = true;
            }else{
                $array['pesado'] = false;
            }
        }else{
            foreach($listaObj as $elem){
                if($elem ['director'] == $peli['director']){
                    $elem['Numero_veces_aparece']++;
                }else{
                    $array['director'] = $peli['director'];
                    $array['Numero_veces_aparece'] = 1;
                    if($peli['director'] == "Christopher Nolan"){
                        $array['pesado'] = true;
                    }else{
                        $array['pesado'] = false;
                    }
                }
            }
        }
        if($array != []){
            $listaObj[] = $array;
        }
    }
    mostrar2($listaObj);
?>