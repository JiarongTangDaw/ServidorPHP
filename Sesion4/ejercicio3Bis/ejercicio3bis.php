<?php
$cadenaXML = <<<xml
<?xml version='1.0' encoding='UTF-8'?>
<contactos></contactos>
xml;

$xml = simplexml_load_string($cadenaXML);

$contacto = $xml->addChild('contacto');
$contacto->addAttribute("id", "1");
$contacto->addChild('nombre', 'Elena Rodriguez');
$contacto->addChild('email', 'elena@gmail.com');
$contacto->addChild('telefono', '55555555');

$contacto = $xml->addChild('contacto');
$contacto->addAttribute("id", "2");
$contacto->addChild('nombre', 'Pablo Pérez');
$contacto->addChild('email', 'pablo@gmail.com');
$contacto->addChild('telefono', '66666666');

$xml->asXML("contactos.xml");
?>

