<?php
//Importo mi fichero de configuracion
$config = require_once __DIR__ . "/config.php";
require_once __DIR__ ."/plataforma.php";
require_once __DIR__ ."/videojuego.php";
$arrtiposcampoImg = ["image", "picture", "img"];

use MongoDB\Driver\Query;
use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;

class Conectores
{
    protected $pdoSqlLite; //Conexion global de la db sqlLite

    public function __construct() {}

    public function conectarSqLite()
    {
        global $config;
        //Este método me conecta al sqllite
        //Inicio las propiedades necesarias en el constructor y hago la conexión la BBDD
        $bbdd = $config['database']['dbname'];
        // Conectar a SQLite
        $this->pdoSqlLite = new PDO('sqlite:' . __DIR__ . "\\datos\\" . $bbdd);
    }
    public function getPdoSqLite()
    {
        return $this->pdoSqlLite;
    }

    public function getCsv()
    {
        //Esta funcion me coge el csv de mi fichero de configuracion y me lo convierte en un array
        global $config;
        $csv = $config['database']['csv'];
        $fichero = __DIR__ . "\\" . $csv;
        $arr_salida = [];
        if (file_exists($fichero)) {
            //Abro el cursor del fichero
            $f = fopen($fichero, "r");

            //Me lo convierto cada linea en un array con el metodo fgetcsv y lo voy añadiendo a mi array final

            //Recordar que el curso se posiciona en la primera linea y siempre hay que leerla
            $array = fgetcsv($f);
            array_push($arr_salida, $array);
            while (!feof($f)) {
                //El bucle me va línea a línea mientras no sea el caracter final de fichero
                $array = fgetcsv($f);
                array_push($arr_salida, $array);
            }

            //Cierro el fichero para evitar errores de memoria
            fclose($f);
        }
        return $arr_salida;
    }
    public function procesarCSV()
    {
        //Esta funcion me convierte el csv al array esperado por la tabla
        $arrVJ = null;

        //Me traigo el csv de la hoja
        $arrVJ = $this->getCsv();

        //Extraigo las plaformas que son la columna 0
        $arrPlataformas = array_map(function ($nav) {
            if (isset($nav[0]) && $nav[0] != "plataforma") {
                return ["plataforma" => $nav[0]];
            }
        }, $arrVJ);

        //Me creo un objeto distinct para sacar solo las plataformas que me interesan
        $arrDistinctPlataformas = [];
        //Recorro cada uno de los video juegos y me creo un array solo con las plataformas con valor único para luego colocarlo
        foreach ($arrPlataformas as $plat) {
            if (isset($plat)) {
                $splataforma = $plat["plataforma"];
                if (in_array($splataforma, $arrDistinctPlataformas) == false) {
                    array_push($arrDistinctPlataformas, $splataforma);
                }
            }
        }

        //Recorro el array de plataformas y me hago un array con las plataformas y sus videojuegos mejor colocado para luego hacer el bucle
        $arrFinalPlataformas = [];
        $iContaPlataforma_id = 1;
        foreach ($arrDistinctPlataformas as $pladis) {
            //Saco los elementos del array principal que son de la plataforma en cuestion
            $arrFilPla = array_filter($arrVJ, function ($VJ) use ($pladis) {
                if (isset($VJ[0])) {
                    return $VJ[0] == $pladis;
                }
            });

            //Mapeo solo los campos que me interesan que titulo anio y metacritic
            $videojuego_id = 1;
            //Paso la variable contador video_juego_id por referencia para poder incrementarlo dentro
            $mapArrFilPla = array_map(function ($oVJ) use ($iContaPlataforma_id, &$videojuego_id) {
                $videojuego = new Videojuego();
                $videojuego->setvideo_juego_id($videojuego_id);
                $videojuego->setplataforma_id($iContaPlataforma_id);
                $videojuego->settitulo($oVJ[1]);
                $videojuego->setanio($oVJ[2]);
                $videojuego->setmetacritic($oVJ[3]);
                $videojuego->setimagen($oVJ[4]);
                $videojuego_id += 1;
                return $videojuego;
            }, $arrFilPla);

            //Genero un objeto con dos propiedades la plataforma y los video juegos de la misma
            $plataforma = new Plataforma();
            $plataforma->setplataforma_id($iContaPlataforma_id);
            $plataforma->setplataforma($pladis);
            $plataforma->setvideojuegos($mapArrFilPla);

            //Añado dicho objeto a la plataforma
            array_push($arrFinalPlataformas, $plataforma);
            $iContaPlataforma_id += 1;
        }
        return $arrFinalPlataformas;
    }

    public function pintarTabla($arrFinalPlataformas)
    {
        //Esta funcion me pinta la tabla a partir del array de objetos de plataforma
        $shtml = "";
        foreach ($arrFinalPlataformas as $pla) {
            //Pinto el titulo
            $plataforma = $pla->getPlataforma();
            $stitulo = "<h1>$plataforma</h1>";
            //echo $stitulo;
            $shtml = $shtml . $stitulo;

            //Pinto la tabla
            $tabla_html = $this->pintarArrayTabla($pla->getvideojuegos());
            //echo $tabla_html;
            $shtml = $shtml . $tabla_html;
            //echo $shtml;
        }
        return $shtml;
    }

    function pintarArrayTabla($arr)
    {
        //Esta funcion me va a pintar un array en una tabla
        //Inicializo la variable html
        $shtml = "<table border='1'>";

        //Recorro el array
        foreach ($arr as $elem) {
            $shtml .= "<tr>";

            //Recorro las propiedades del array y las voy pintando en tds
            $tipo = gettype($elem);
            if ($tipo == "array" || $tipo == "object") {
                foreach ($elem as $clave => $valor) {
                    $shtml .= "<td>" . (string)$valor . "</td>";
                }
            } else {
                $shtml .= "<td>" . (string)$elem . "</td>";
            }

            $shtml .= "</tr>";
        }

        //ACordaros que el punto es concatenador en PECHAPE
        $shtml .= "</table>";

        return $shtml;
    }

    function pintarArrayDiv2($arr)
    {
        global $arrtiposcampoImg;
        //Esta funcion me va a pintar un array en una tabla
        //Inicializo la variable html
        $shtml = "<div class='principal'>";

        //Recorro el array
        foreach ($arr as $elem) {

            //Recorro las propiedades del array y las voy pintando en tds
            $tipo = gettype($elem);
            if ($tipo == "array" || $tipo == "object") {
                $shtml .= "<div class='elemento'>";
                foreach ($elem as $clave => $valor) {
                    //Compruebo si la clave es de tipo imagen
                    if (in_array($clave, $arrtiposcampoImg)) {
                        $shtml .= "<img src='$valor' />";
                    } else {
                        $shtml .= "<h6><b>" . (string)$clave . "</b>". (string)$valor ."</h6>";
                    }
                }
                $shtml .= "</div>";
            } else {
                $shtml .= "<div>" . (string)$elem . "</div>";
            }
        }

        //ACordaros que el punto es concatenador en PECHAPE
        $shtml .= "</div>";

        return $shtml;
    }

    public function procesarXML()
    {
        //Esta funcion me coge el xml de mi fichero de configuracion y me lo convierte en un array
        global $config;
        $xml = $config['database']['xml'];
        $fichero = __DIR__ . "\\". $xml;
        $arr_salida = [];
        if (file_exists($fichero)) {
            $xml = simplexml_load_file($fichero);
            $juegoId = 1;
            $arrayPlataformas = [];
            foreach ($xml->juego as $juego) {
                $keys = array_keys($arrayPlataformas);
                $plataforma = (string) $juego['plataforma'];
                if(!in_array($plataforma,$keys)){
                   $arrayPlataformas[$plataforma] = [];
                }
                $titulo = (string) $juego->titulo;
                $anio = (int) $juego->anio;
                $metacritic = (string) $juego->metacritic;
                $imagen = (string) $juego->portada;
                $plataformaId = array_search($plataforma, $keys) + 1;
                $newJuego = new Videojuego();
                $newJuego->setvideo_juego_id($juegoId);
                $newJuego->setplataforma_id($plataformaId);
                $newJuego->settitulo($titulo);
                $newJuego->setanio($anio);
                $newJuego->setmetacritic($metacritic);
                $newJuego->setimagen($imagen);
                array_push($arrayPlataformas[$plataforma], $newJuego);
                $juegoId += 1;
            }
            $plataformaId = 1;
            foreach($arrayPlataformas as $key => $juegos){
                $platform = new Plataforma();
                $platform->setplataforma_id($plataformaId);
                $platform->setplataforma($key);
                $platform->setvideojuegos($juegos);
                array_push($arr_salida, $platform);
                $plataformaId += 1;
            }
        }
        return $arr_salida;
    }
    public function procesarJSON()
    {
        //Esta funcion me coge el xml de mi fichero de configuracion y me lo convierte en un array
        global $config;
        $json = $config['database']['json'];
        $fichero = __DIR__ . "\\". $json;
        $arr_salida = [];
        if (file_exists($fichero)) {
            $json = file_get_contents($fichero);
            $datos = json_decode($json, true);
            $idPlataforma = 1;
            foreach($datos['plataformas'] as $plataforma){
                $plataformaNombre = $plataforma['nombre'];
                $arrayJuegos = [];
                $idJuego = 1;
                foreach($plataforma['juegos'] as $juego){
                    $titulo = $juego['titulo'];
                    $anio = (int) $juego['anio'];
                    $metacritic = (string) $juego['metacritic'];
                    $imagen = (string) $juego['portada'];
                    $newJuego = new Videojuego();
                    $newJuego->setvideo_juego_id($idJuego);
                    $newJuego->setplataforma_id($idPlataforma);
                    $newJuego->settitulo($titulo);
                    $newJuego->setanio($anio);
                    $newJuego->setmetacritic($metacritic);
                    $newJuego->setimagen($imagen);
                    array_push($arrayJuegos, $newJuego);
                }
                $platform = new Plataforma();
                $platform->setplataforma_id($idPlataforma);
                $platform->setplataforma($plataformaNombre);
                $platform->setvideojuegos($arrayJuegos);
                array_push($arr_salida, $platform);
                $idPlataforma += 1;
            }
        }
        return $arr_salida;
    }

    function pintarArrayDiv($arr)
    {
        global $arrtiposcampoImg;
        
        $shtml = "<div class='principal'>";

        // Recorro el array de plataformas
        foreach ($arr as $plataforma) {
            $tipo = gettype($plataforma);
            
            if ($tipo == "array" || $tipo == "object") {
                $shtml .= "<div class='plataforma'>";
                
                // Recorro las propiedades de cada plataforma
                foreach ($plataforma as $clave => $valor) {
                    
                    // Si la propiedad es 'videojuegos', procesarla especialmente
                    if ($clave === 'videojuegos' && (is_array($valor) || is_object($valor))) {
                        $shtml .= "<div class='lista-videojuegos'>";
                        
                        // Recorrer cada videojuego
                        foreach ($valor as $videojuego) {
                            $shtml .= "<div class='videojuego'>";
                            
                            // PRIMER RECORRIDO: Mostrar solo las imágenes
                            foreach ($videojuego as $claveVj => $valorVj) {
                                // Excluir IDs
                                if ($claveVj === 'plataforma_id' || $claveVj === 'video_juego_id') {
                                    continue;
                                }
                                
                                // Mostrar solo imágenes
                                if ($claveVj === 'imagen' || in_array($claveVj, $arrtiposcampoImg)) {
                                    $shtml .= "<img src='$valorVj' alt='".$videojuego->gettitulo()."' class='portada-juego' />";
                                }
                            }
                            
                            // SEGUNDO RECORRIDO: Mostrar el resto de propiedades
                            foreach ($videojuego as $claveVj => $valorVj) {
                                // Excluir IDs
                                if ($claveVj === 'plataforma_id' || $claveVj === 'video_juego_id') {
                                    continue;
                                }
                                
                                // Mostrar solo campos que NO son imágenes
                                if ($claveVj !== 'imagen' && !in_array($claveVj, $arrtiposcampoImg)) {
                                    $shtml .= "<p><b>" . ucfirst((string)$claveVj) . ":</b> " . (string)$valorVj . "</p>";
                                }
                            }
                            
                            $shtml .= "</div>"; // Cierre videojuego
                        }
                        
                        $shtml .= "</div>"; // Cierre lista-videojuegos
                        $shtml .="<hr style='border:1px solid red'>";
                    } else {
                        // Propiedades normales de la plataforma (solo 'plataforma')
                        if (in_array($clave, $arrtiposcampoImg)) {
                            $shtml .= "<img src='$valor' alt='$clave' />";
                        } else {
                            $shtml .= "<h3><b>" . ucfirst((string)$clave) . ":</b> " . (string)$valor . "</h3>";
                        }
                    }
                }
                
                $shtml .= "</div>"; // Cierre plataforma
                
            } else {
                $shtml .= "<div>" . (string)$plataforma . "</div>";
            }
        }

        $shtml .= "</div>"; // Cierre principal

        return $shtml;
    }
    public function procesarMySQL()
    {
        //Esta funcion me coge el xml de mi fichero de configuracion y me lo convierte en un array
        global $config;
        $mysql = $config['database']['mysql'];
        $cadena = 'mysql:host='. $mysql['host'].':'.$mysql['puerto'].';dbname='. $mysql['database'];
        $arr_salida = [];
        try {
            $pdo = new PDO($cadena, $mysql['usuario'], $mysql['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("SET NAMES 'utf8'");
            $sql = "SELECT V.id, V.titulo, P.nombre AS plataforma, P.id AS plataforma_id, V.metacritic, V.portada, V.anio
                    FROM juegos V 
                    INNER JOIN plataformas P ON V.plataforma_id = P.id";
            $lista = $pdo->query($sql);
            $arrayPlataforma = [];
            while ($videojuego = $lista->fetch()) {
                $plataforma = $videojuego['plataforma'];
                $keys = array_keys($arrayPlataforma);
                if(!in_array($plataforma, $keys)){
                    $arrayPlataforma[$plataforma] = [];
                }
                $arrayPlataforma[$plataforma][] = $videojuego;
                
            };
            $plataformaId = 1;
            foreach ($arrayPlataforma as $plataforma => $juegos) {
                $arrayJuegos = [];
                foreach($juegos as $juego){
                    $titulo = $juego['titulo'];
                    $metacritic = (string) $juego['metacritic'];
                    $imagen = (string) $juego['portada'];
                    $anio = (int) $juego['anio'];
                    $juegoId = (int) $juego['id'];
                    $newJuego = new Videojuego();
                    $newJuego->setvideo_juego_id($juegoId);
                    $newJuego->setplataforma_id($plataformaId);
                    $newJuego->settitulo($titulo);
                    $newJuego->setmetacritic($metacritic);
                    $newJuego->setanio($anio);
                    $newJuego->setimagen($imagen);
                    array_push($arrayJuegos, $newJuego);
                }
                $platform = new Plataforma();
                $platform->setplataforma_id($plataformaId);
                $platform->setplataforma($plataforma);
                $platform->setvideojuegos($arrayJuegos);
                array_push($arr_salida, $platform);
                $plataformaId += 1;
            }
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
        return $arr_salida;
    }
    public function procesarMongoDB()
    {
        //Esta funcion me coge el xml de mi fichero de configuracion y me lo convierte en un array
        global $config;
        $mongo = $config['database']['mongodb'];
        $cadena = 'mongodb://'. $mongo['usuario']. ':' . $mongo['password'] . '@'. $mongo['host'] . ':' . $mongo['puerto'] . '/' . $mongo['database'];
        $arr_salida = [];
        try {
            $conexion = new Manager ($cadena);
            $datos = $conexion->executeQuery('videojuegos_db_jia.plataformas', new Query([], []));
            $datos = $datos->toArray();
            $platID = 1;
            foreach($datos as $plataforma){
                $nombrePla = $plataforma->nombre;
                $arrayJuegos = [];
                foreach($plataforma->juegos as $juego){
                    $titulo = $juego->titulo;
                    $juegoID = $juego->id;
                    $anio = $juego->anio;
                    $imagen = $juego->portada;
                    $metacritic = $juego->metacritic;
                    $newJuego = new Videojuego();
                    $newJuego->setvideo_juego_id($juegoID);
                    $newJuego->setplataforma_id($platID);
                    $newJuego->settitulo($titulo);
                    $newJuego->setmetacritic($metacritic);
                    $newJuego->setanio($anio);
                    $newJuego->setimagen($imagen);
                    array_push($arrayJuegos, $newJuego); 
                }
                $platform = new Plataforma();
                $platform->setplataforma_id($platID);
                $platform->setplataforma($nombrePla);
                $platform->setvideojuegos($arrayJuegos);
                array_push($arr_salida, $platform);
                $platID += 1;
            }
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
        return $arr_salida;
    }
}
