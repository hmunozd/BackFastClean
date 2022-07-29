<?php

namespace App\Http\Controllers;

use App\TipoIdentificacion;
use Illuminate\Http\Request;

class TipoIdentificacionController extends Controller
{
    function getIdentificaciones()
    {
        $result = TipoIdentificacion::all();
        return response()->json([
            'status' => 1,
            'datos' => $result
        ]);
    }
}
