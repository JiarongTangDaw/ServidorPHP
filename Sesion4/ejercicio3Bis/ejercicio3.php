<?php
$fichero = "agenda.xml";
if (file_exists($fichero)) {
    $xml = simplexml_load_file($fichero);
    foreach ($xml->contacto as $contacto) {
        echo "Id: " . $contacto['id'] . "<br/>";
        echo "Nombre: " . $contacto->nombre . "<br/>";
        echo "Email: " . $contacto->email . "<br/>";
        echo "Teléfono: " . $contacto->telefono . "<br/>";
        echo "<br/>";
    }
} else {
    echo "El fichero no existe";
}
?>
