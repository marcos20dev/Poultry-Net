<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjustesController extends Controller
{
    public function mostrarformulario()
    {
        $sectores = \App\Models\Sector::all();

        return view('dashboard.ajustes.ajustes', compact('sectores'));
    }

}
