<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlataformasMongo;
use App\Http\Controllers\FilaMongo;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('plataformasMongo', PlataformasMongo::class);
Route::apiResource('filasMongo', FilaMongo::class);
