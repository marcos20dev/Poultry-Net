<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RutasController extends Controller
{
    public function __invoke()
    {
        return view('index');
    }

    public function mostrarFormularioRegistro()
    {
        return view('auth.registrar');
    }
}
