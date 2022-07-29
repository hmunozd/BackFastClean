<?php

namespace App\Http\Controllers;

use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    /**
     * Funcion que ejecuta un SP
     * insertando el registro si este cumple
     * con las condiciones
     * @param ParametrosHTTP 
     */
    public function insertarPersona(Request $request)
    {
        #Construimos las validaciones a cada uno de los campos recibidos en el POST
        $userValidator = Validator::make($request->all(), [
            'tipoIdentificacion' => 'required',
            'primerNombre' => 'required',
            'identificacion' => 'required',
            'segundoNombre' => '',
            'primerApellido' => 'required',
            'segundoApellido' => '',
            'direccion' => 'required',
            'celular' => 'required',
            'telefono' => '',
            'ciudad' => 'required',
            'cargo' => 'required',
        ]);
        $params = $request->all();
        foreach ($params as &$valor) {
            isset($valor) ? $valor : $valor = '';
        }
        #Si los campos estan llenos como corresponde
        if (!$userValidator->fails()) {
            #Ejecutamos el SP con sus respectivos parametros
            $result = DB::executeProcedure("SP_NUEVA_PERSONA", [
                $request['primerNombre'],
                $request['segundoNombre'],
                $request['primerApellido'],
                $request['segundoApellido'],
                $request['identificacion'],
                $request['direccion'],
                $request['celular'],
                $request['telefono'],
                $request['ciudad'],
                $request['tipoIdentificacion'],
                $request['cargo']
            ]);
            #Si el SP se ejecuto
            if ($result) {
                #Devolvemos una respuesta satisfactoria
                return response()->json([
                    'status' => 200,
                    'message' => "¡Se ha insertado la persona con exito!"
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'errors' => 'No se pudo insertar la persona'
                ]);
            }
            #Si hay inconvenientes con los campos 
        } else {
            #Mostramos los inconvenientes
            return response()->json([
                'status' => 400,
                'errors' => $userValidator->errors()
            ]);
        }
    }

    /**
     * Funcion que ejecuta un SP
     * editando el registro si este cumple
     * con las condiciones
     * @param ParametrosHTTP 
     */
    public function editarUsuario(Request $request)
    {
        $userValidator = Validator::make(
            $request->all(),
            [
                'id_persona' => 'required',
                'tipoIdentificacion' => 'required',
                'primerNombre' => 'required',
                'identificacion' => 'required',
                'segundoNombre' => '',
                'primerApellido' => 'required',
                'segundoApellido' => '',
                'direccion' => 'required',
                'celular' => 'required',
                'telefono' => '',
                'ciudad' => 'required',
                'cargo' => 'required',
            ]
        );
        #Si los campos estan llenos como corresponde
        if (!$userValidator->fails()) {
            $params = $request->all();
            foreach ($params as &$valor) {
                isset($valor) ? $valor : $valor = '';
            }
            #Buscamos el usuario que vamos a editar
            $searchUser = Persona::where('id_persona', $params['id_persona'])->first();

            if ($searchUser) {
                #Ejecutamos el SP con sus respectivos parametros
                $result = DB::executeProcedure("SP_EDITAR_PERSONA", [
                    $params['id_persona'],
                    $params['primerNombre'],
                    $params['segundoNombre'],
                    $params['primerApellido'],
                    $params['segundoApellido'],
                    $params['identificacion'],
                    $params['direccion'],
                    $params['celular'],
                    $params['telefono'],
                    $params['ciudad'],
                    $params['tipoIdentificacion'],
                    $params['cargo']
                ]);
                #Si el SP se ejecuto
                if ($result) {
                    #Devolvemos una respuesta satisfactoria
                    return response()->json([
                        'status' => 1,
                        'message' => "¡Se ha actualizado el usuario con exito!"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'Usuario aún no registrado en el sistema.'
                ]);
            }

            #Si hay inconvenientes con los campos 
        } else {
            #Mostramos los inconvenientes
            return response()->json([
                'status' => 0,
                'errors' => $userValidator->errors()
            ]);
        }
    }

    /**
     * Funcion que ejecuta un SP
     * eliminando el registro si este cumple
     * con las condiciones
     * @param ParametrosHTTP 
     */
    public function eliminarPersona($id)
    {
        if (isset($id)) {
            #Buscamos el usuario que vamos a eliminar
            $searchUser = Persona::where('id_persona', $id)->first();

            if ($searchUser) {
                #Ejecutamos el SP con sus respectivos parametros
                $result = DB::executeProcedure("SP_ELIMINAR_PERSONA", [
                    $id
                ]);

                #Si el SP se ejecuto
                if ($result) {
                    #Devolvemos una respuesta satisfactoria
                    return response()->json([
                        'status' => 200,
                        'message' => "¡Se ha eliminado el usuario con exito!"
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => "¡No se pudo eliminar la persona!"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'La persona no esta registrada'
                ]);
            }

            #Si hay inconvenientes con los campos 
        } else {
            #Mostramos los inconvenientes
            return response()->json([
                'status' => 400,
                'errors' => 'Error de peticion'
            ]);
        }
    }

    /**
     * Funcion que obtiene un usuario
     * eliminando el registro si este cumple
     * con las condiciones
     * @param ParametrosHTTP 
     */
    public function obtenerPersona($id)
    {
        if (isset($id)) {
            #Buscamos el usuario que vamos a seleccionar
            $searchUser = Persona::where('id_persona', $id)->first();

            if ($searchUser) {
                #Devolvemos una respuesta satisfactoria
                return response()->json([
                    'status' => 200,
                    'message' => "¡Se ha obtenido el usuario con exito!",
                    'datos' => $searchUser
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Usuario aún no registrado en el sistema.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Error de peticion.'
            ]);
        }
    }

    public function obtenerPersonas()
    {
        $personas = DB::table('persona')
            ->join('ciudad', 'ciudad.id_ciudad', '=', 'persona.id_ciudad_fk')
            ->join('tipo_identificacion', 'tipo_identificacion.id_tipo_identificacion', '=', 'persona.id_tipo_identificacion_fk')
            ->join('cargo_persona', 'cargo_persona.id_cargo', '=', 'persona.id_cargo_fk')
            ->select('persona.*', 'ciudad.nombre AS ciudad', 'tipo_identificacion.nombre AS tipo_identificacion', 'cargo_persona.nombre AS cargo')
            ->get();
        return response()->json([
            'status' => 200,
            'datos' => $personas
        ]);
    }
}
