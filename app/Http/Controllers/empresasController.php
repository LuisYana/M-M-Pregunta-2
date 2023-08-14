<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\empresas;


class empresasController extends Controller
{
    function listarEmpresas(Request $request){
       $empresas = DB::table('empresas')->get();
       return $empresas;
    }

    function agregarEmpresa(Request $request){
        $ruc = $request->nroRuc;
        $razonSocial = $request->razonSocial;
        $direccion = $request->direccion;
        $distrito = $request->distrito;
        if(!$ruc || !$razonSocial || !$direccion || !$distrito){
            return response()->json("Todos los datos son necesarios.");
        }
        else{
            $existeRuc = DB::table('empresas')->where('nroRuc', $ruc)->exists();
            if($existeRuc){
                return response()->json("El RUC " . $ruc . " ya existe.");
            }
            else{
                $insert = DB::table('empresas')->insert([
                    'nroRuc' => $ruc,
                    'razonSocial' => $razonSocial,
                    'direccion' => $direccion,
                    'distrito' => $distrito
                ]);
                if($insert){
                    return response()->json(DB::table('empresas')->orderBy('idEmpresa', 'desc')->first());
                } else {
                    return response()->json("Ocurrió un error, por favor intentalo de nuevo.");
                }
            }
        }
        return response()->json($ruc);
     }

    //  function editarEmpresa(Request $request){
    //     $empresas = DB::table('empresas')->get();
    //     return $empresas;
    //  }

    //  function eliminarEmpresa(Request $request){
    //     $empresas = DB::table('empresas')->get();
    //     return $empresas;
    //  }
}
