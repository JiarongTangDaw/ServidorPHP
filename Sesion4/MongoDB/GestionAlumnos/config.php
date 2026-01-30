<?php
//Siempre es interesante en todo tipo de proyectos tener un fichero de configuracion 
//con las conexiones y parametrizaciones del sistema

//new PDO('mysql:host=hostname;dbname=database', 'usuario', 'password');
//new Manager('mongodb://fidel:1234@localhost:27017/test');
// Los ajustes están definidos dentro de un array
return [
    // Configuración de la base de datos
    'database' => [
        'csv'   => 'DatosRubrica4Final.csv',
        'json'   => 'DatosRubricaFinal.json',
        'xml'   => 'DatosRubricaFinal.xml',
        'mongodb'   => [
            'host' => '192.168.108.100',
            'database' => 'videojuegos_db_jia',
            'puerto' => '27017',
            'usuario' => 'jorge',
            'password' => '1234',
        ],
    ],

];
