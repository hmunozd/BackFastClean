<?php

namespace App\Http\Controllers;

use App\CargoPersona;
use Illuminate\Http\Request;

class CargoPersonaController extends Controller
{
    function getCargoPersonas()
    {
        $result = CargoPersona::all();

        return response()->json([
            'status' => 200,
            'datos' => $result
        ]);
    }
}
