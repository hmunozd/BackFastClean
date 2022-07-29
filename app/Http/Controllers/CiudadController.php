<?php

namespace App\Http\Controllers;

use App\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Pdo\Oci8\Statement;
use PDO;

class CiudadController extends Controller
{
    function getCiudades()
    {
        $result = Ciudad::all();

        return response()->json([
            'status' => 200,
            'datos' => $result
        ]);
        // $cursor = DB::executeProcedure('SP_GET_CIUDAD', [], null);
        // $statement = new Statement($cursor, $this->getPdo());
        // $statement->execute();
        // $result = $statement->fetchAll(PDO::FETCH_CLASS);
        // $statement->closeCursor();

        // dd($result);

    }
}
