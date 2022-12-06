<?php

namespace App\Http\Controllers;

use App\Models\Parques;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParquesController extends Controller
{
    public function insert_park(Request $request)
    {
        $validator_parques = Validator::make($request->all(), [
            'nombre_parques' => 'required',
            'direccion_parques' => 'required',
            'telefono_parques' => 'required',
            'codigo_municipios' => 'required',
        ]);

        $codigo_parques = "P00".Parques::get()->count();

        if (!$validator_parques->fails()) {
            $grupos_insert = Parques::insert([
                'Codigo_Parques' => $codigo_parques,
                'Nombre_Parques' => $request->nombre_parques,
                'Direccion_Parques' => $request->direccion_parques,
                'Telefono_Parques' => $request->telefono_parques,
                'Codigo_Municipios' => $request->codigo_municipios
            ]);
            DB::commit();

            if ($grupos_insert) {
                return response()->json([
                    'status' => true,
                    'message' => "¡Se ha insertado el parque con exito!"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator_parques->messages()
            ]);
        }
    }

    public function update_park(Request $request, $codigo_parques)
    {
        $validator_parques = Validator::make($request->all(), [
            'nombre_parques' => 'required',
            'direccion_parques' => 'required',
            'telefono_parques' => 'required',
            'codigo_municipios' => 'required',
        ]);

        if (!$validator_parques->fails()) {
            if ($this->validated_existence($codigo_parques)) {
                $update_park = DB::table('parques')
                    ->where('Codigo_Parques', $codigo_parques)
                    ->update([
                        'Nombre_Parques' => $request->nombre_parques,
                        'Direccion_Parques' => $request->direccion_parques,
                        'Telefono_Parques' => $request->telefono_parques,
                        'Codigo_Municipios' => $request->codigo_municipios,
                    ]);
                DB::commit();
                if ($update_park) {
                    return response()->json([
                        'status' => true,
                        'message' => "¡Se ha actualizado el parque con exito!"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'El parque que intentas registrar ya existe'
                ]);
            }

            #Si hay inconvenientes con los campos 
        } else {
            #Mostramos los inconvenientes
            return response()->json([
                'status' => true,
                'errors' => $validator_parques->messages()
            ]);
        }
    }

    public function delete_park($codigo_parques)
    {
        if ($this->validated_existence($codigo_parques)) {
            if (Parques::where('Codigo_Parques', $codigo_parques)->delete()) {
                DB::commit();
                #Devolvemos una respuesta satisfactoria
                return response()->json([
                    'status' => true,
                    'message' => "¡Se ha eliminado el parque con exito!"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Parque aún no registrado en el sistema.'
            ]);
        }
    }

    public function find_one_park($codigo_parques)
    {
        if ($this->validated_existence($codigo_parques)) {
            return response()->json([
                'status' => true,
                'message' => "¡Se ha obtenido el parque con exito!",
                'data' => $this->get_park($codigo_parques)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'data' => 'El parque aún no se encuentra registrado'
            ]);
        }
    }
    public function validated_existence($codigo_parques)
    {
        return $this->get_park($codigo_parques) ? true : false;
    }

    private function get_park($codigo_parques)
    {
        DB::commit();
        return Parques::where('Codigo_parques', '=', $codigo_parques)->first();
    }

    public function find_park()
    {
        DB::commit();
        $parks = Parques::all();
        return response()->json([
            'status' => true,
            'data' => $parks
        ]);
    }

    public function find_municipios(){
        {
            DB::commit();
            $municipios = DB::table('municipios')->get();
            return response()->json([
                'status' => true,
                'data' => $municipios
            ]);
        }
    }
}