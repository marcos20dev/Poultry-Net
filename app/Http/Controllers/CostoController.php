<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CostoController extends Controller
{
    public function index()
    {
        return view('site.costos.costos');
    }

}
