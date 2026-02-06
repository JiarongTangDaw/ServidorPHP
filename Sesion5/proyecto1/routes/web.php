<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\FilaMongo;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hola', function () {
    return "Hola desde mi primera ruta en Laravel";
});

Route::get('/hola/{nombre}', function ($nombre) {
    return "Hola, $nombre";
});

Route::get('/hola2/{nombre?}', function ($nombre = "Anónimo") {
    return "Hola, $nombre";
});

Route::resource('/alumnos', AlumnosController::class);

Route::resource('/mongo', FilaMongo::class);
