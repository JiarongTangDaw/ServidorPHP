<?php
    require_once 'datos.php';

    // funcion para mostrar arrays simples
    function mostrar($lista){
        foreach($lista as $elem){
            echo "$elem <br>";
        }
    }
    // funcion para mostrar arrays asociativos
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
    $copia = $movieTitles;
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
    $miLista = $movieTitles;

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
    $copia2 = $bestMovies;
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
    $miLista2 = $bestMovies;

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
        // buscar en la lista de objetos si tengo un elemento con es mismo nombre de director que el bestMovies
        $existeDirector = array_filter($listaObj,function($elem) use($peli){
            return $elem['director'] == $peli['director'];
        });
        // si no hay ninguno con el mismo director
        if(count($existeDirector) == 0){
            // busca en el array de bestMovies las pelis que tiene el mismo director que el dado
            $listDirector = array_filter($bestMovies,function($elem) use ($peli){
                 return $elem['director'] == $peli['director'];
            });
            // cuenta el numero de elementos en la lista director
            $numDirec = count($listDirector);
            $esPesado = false;
            // comprueba si el director es Christopher Nolan
            if($peli['director'] == "Christopher Nolan"){
                $esPesado = true;
            }
            //añadir en el array final el nuevo elemento al final
            array_push($listaObj, ["director" => $peli['director'], "Contador" => $numDirec, "pesado" => $esPesado]);
        };
    };
    mostrar2($listaObj);
?>