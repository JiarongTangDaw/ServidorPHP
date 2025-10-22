<?php

function buscarCapital($pais)
{
    global $capitales;
    $capitalPais = "";
    foreach ($capitales as $capital) {
        if ($capital -> pais === $pais) {
            $capitalPais = $capital -> capital;
            break;
        };
    }
    return $capitalPais;
}

$paises = [
  (object)[ "nombre" => "China", "habitantes" => 1410470000, "superficie" => 9596961 ],
  (object)[ "nombre" => "India", "habitantes" => 1382600000, "superficie" => 3287263 ],
  (object)[ "nombre" => "Estados Unidos", "habitantes" => 339000000, "superficie" => 9833517 ],
  (object)[ "nombre" => "Indonesia", "habitantes" => 275500000, "superficie" => 1904569 ],
  (object)[ "nombre" => "Pakistán", "habitantes" => 240500000, "superficie" => 770880 ],
  (object)[ "nombre" => "Brazil", "habitantes" => 215000000, "superficie" => 8515770 ],
  (object)[ "nombre" => "Nigeria", "habitantes" => 224000000, "superficie" => 923768 ],
  (object)[ "nombre" => "Bangladesh", "habitantes" => 171000000, "superficie" => 147570 ],
  (object)[ "nombre" => "Rusia", "habitantes" => 146000000, "superficie" => 17098242 ],
  (object)[ "nombre" => "México", "habitantes" => 133000000, "superficie" => 1964375 ],
  (object)[ "nombre" => "Japón", "habitantes" => 124000000, "superficie" => 377975 ],
  (object)[ "nombre" => "Etiopía", "habitantes" => 120000000, "superficie" => 1104300 ],
  (object)[ "nombre" => "Filipinas", "habitantes" => 116000000, "superficie" => 300000 ],
  (object)[ "nombre" => "Egipto", "habitantes" => 110000000, "superficie" => 1002450 ],
  (object)[ "nombre" => "Vietnam", "habitantes" => 103000000, "superficie" => 331212 ],
  (object)[ "nombre" => "República Democrática del Congo", "habitantes" => 110000000, "superficie" => 2344858 ],
  (object)[ "nombre" => "Irán", "habitantes" => 86000000, "superficie" => 1648195 ],
  (object)[ "nombre" => "Turquía", "habitantes" => 86000000, "superficie" => 783562 ],
  (object)[ "nombre" => "Alemania", "habitantes" => 84000000, "superficie" => 357022 ],
  (object)[ "nombre" => "Tailandia", "habitantes" => 70000000, "superficie" => 510890 ]
];

$capitales = [
  (object)["pais" => "China", "capital" => "Beijing"],
  (object)["pais" => "India", "capital" => "Nueva Delhi"],
  (object)["pais" => "Estados Unidos", "capital" => "Washington D.C."],
  (object)["pais" => "Indonesia", "capital" => "Yakarta"],
  (object)["pais" => "Pakistán", "capital" => "Islamabad"],
  (object)["pais" => "Brazil", "capital" => "Brasilia"],
  (object)["pais" => "Nigeria", "capital" => "Abuya"],
  (object)["pais" => "Bangladesh", "capital" => "Daca"],
  (object)["pais" => "Rusia", "capital" => "Moscú"],
  (object)["pais" => "México", "capital" => "Ciudad de México"],
  (object)["pais" => "Japón", "capital" => "Tokio"],
  (object)["pais" => "Etiopía", "capital" => "Adís Abeba"],
  (object)["pais" => "Filipinas", "capital" => "Manila"],
  (object)["pais" => "Egipto", "capital" => "El Cairo"],
  (object)["pais" => "Vietnam", "capital" => "Hanói"],
  (object)["pais" => "República Democrática del Congo", "capital" => "Kinshasa"],
  (object)["pais" => "Irán", "capital" => "Teherán"],
  (object)["pais" => "Turquía", "capital" => "Ankara"],
  (object)["pais" => "Alemania", "capital" => "Berlín"],
  (object)["pais" => "Tailandia", "capital" => "Bangkok"]
];


//VAMOS A HACER UN EJERCICIO
//VAMOS A HACER UN TABLE DONDE LAS COLUMNAS SEAN
// NOMBRE DEL PAIS
//Segunda columna capital pero que este centrada
//tercera columna habitantes
//CUARTA columna SUPERFICIE
//PEEERO QUIERO QUE EL ORIGEN DE DATOS DEL BUCLE DEL ARRAY SEA UN ARRAY NUEVO SOLO CON LAS CUATRO COLUMNAS
//NO QUIERO QUE TENGA 5 SINO 4


$tabla = "<table border='1'>";
$tabla .= "<thead>";
$tabla .= "<tr>";
$tabla .= "<th>Nombre Pais</th>";
$tabla .= "<th>Capital</th>";
$tabla .= "<th>Habitantes</th>";
$tabla .= "<th>Superficie</th>";
$tabla .= "</tr>";
$tabla .= "</thead>";
$tabla .= "<tbody>";

//   $nuevoPaises = [];

//   foreach($paises as $pais){
//     $nombre = "";
//     if($pais -> nombre !== null){
//       $nombre = $pais -> nombre;
//     };

//     $habitantes = 0;
//     if($pais -> habitantes !== null){
//       $habitantes = $pais -> habitantes;
//     };

//     $superficie = 0;
//     if($pais -> superficie !== null){
//       $superficie = $pais -> superficie;
//     };

//     $capital = buscarCapital($nombre);

//     $nuevoPaises[] = (object)[
//         "nombre" => $nombre,
//         "capital" => $capital,
//         "habitantes" => $habitantes,
//         "superficie" => $superficie
//     ];

//   }

//   foreach ($nuevoPaises as $pais) {
//     $nombre = "";
//     if($pais -> nombre !== null){
//       $nombre = $pais -> nombre;
//     };

//     $habitantes = 0;
//     if($pais -> habitantes !== null){
//       $habitantes = $pais -> habitantes;
//     };

//     $superficie = 0;
//     if($pais -> superficie !== null){
//       $superficie = $pais -> superficie;
//     };

//     $capital = "";
//     if($pais -> capital !== null){
//       $nombre = $pais -> capital;
//     };

//     $tabla .= "<tr>";
//     $tabla .= "<td>$nombre</td>";
//     $tabla .= "<td style=\"text-align:center\">$capital</td>";
//     $tabla .= "<td>$habitantes</td>";
//     $tabla .= "<td>$superficie</td>";
//     $tabla .= "</tr>";
//   }

//! otra solucion

// $nuevoPaises = $paises //si se hace cambios en $nuevoPaises se realiza cambios en $paises

// * clonacion de objetos del array paises de forma manual
//   $nuevoPaises = [];
//   foreach ($paises as $pais) {
//     $nuevoPaises[] = clone($pais);
//   }

// * clonacion profunda del array de objetos
$nuevoPaises = unserialize(serialize($paises));
// TODO: serialize(array) conbierte el array en string
// TODO: unserialize() reconstruye el array completo creando nuevos objetos desde un string

foreach ($nuevoPaises as $pais) {
    $nombre = "";
    if ($pais -> nombre !== null) {
        $nombre = $pais -> nombre;
    };

    $habitantes = 0;
    if ($pais -> habitantes !== null) {
        $habitantes = $pais -> habitantes;
    };

    $superficie = 0;
    if ($pais -> superficie !== null) {
        $superficie = $pais -> superficie;
    };

    $capital = buscarCapital($nombre);

    $pais-> capital = $capital;

    $tabla .= "<tr>";
    $tabla .= "<td>$nombre</td>";
    $tabla .= "<td style=\"text-align:center\">$capital</td>";
    $tabla .= "<td>$habitantes</td>";
    $tabla .= "<td>$superficie</td>";
    $tabla .= "</tr>";
}

$tabla .= "</tbody>";
$tabla .= "</table>";

echo $tabla;
