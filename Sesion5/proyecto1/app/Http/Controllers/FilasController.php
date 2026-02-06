<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FilasController extends Controller
{
    public function alta()
    {
        return "Llamando al metodo alta() desde el controlador FilasController";
    }
}
