<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class contactoController extends Controller
{
    function listarContactos(Request $request){
        $contactos = DB::table('contactos')->where('eliminado', false)->get();
        return $contactos;
    }
 
    function agregarContacto(Request $request){
        $nombre = $request->nombre;
        $celular = $request->celular;
        $direccion = $request->direccion;
        $correo = $request->correo;
        $idEmpresa = $request->idEmpresa;
        if(!$nombre || !$celular || !$direccion || !$correo || !$idEmpresa){
            return response()->json("Todos los datos son necesarios.");
        }
        else{
            $existeEmpresa = DB::table('empresas')->where('idEmpresa', $idEmpresa)->exists();
            if($existeEmpresa){
                $insert = DB::table('contactos')->insert([
                    'nombre' => $nombre,
                    'celular' => $celular,
                    'direccion' => $direccion,
                    'correo' => $correo,
                    'eliminado' => false,
                    'idEmpresa' => $idEmpresa
                ]);
                if($insert){
                    return response()->json(DB::table('contactos')->orderBy('idContacto', 'desc')->first());
                } else {
                    return response()->json("Ocurrió un error, por favor intentalo de nuevo.");
                }
            }
            else{
                return response()->json("La empresa con ID: " . $idEmpresa . " no existe.");
            }
        }
    }

    function editarContacto(Request $request){
        $idContacto = $request->idContacto;
        $nombre = $request->nombre;
        $celular = $request->celular;
        $direccion = $request->direccion;
        $correo = $request->correo;
        $idEmpresa = $request->idEmpresa;
        if(!$idContacto || !$nombre || !$celular || !$direccion || !$correo || !$idEmpresa){
            return response()->json("Todos los datos son necesarios.");
        }
        else{
            $existeEmpresa = DB::table('empresas')->where('idEmpresa', $idEmpresa)->exists();
            if($existeEmpresa){
                $existeContacto = DB::table('contactos')->where('idContacto', $idContacto)->exists();
                if($existeContacto){
                    $update = DB::table('contactos')->where('idContacto', $idContacto)->update([
                        'nombre' => $nombre,
                        'celular' => $celular,
                        'direccion' => $direccion,
                        'correo' => $correo,
                        'eliminado' => false,
                        'idEmpresa' => $idEmpresa
                    ]);
                    if($update){
                        return response()->json("Se actualizó el contacto correctamente.");
                    } else {
                        return response()->json("Ocurrió un error, por favor intentalo de nuevo.");
                    }
                }
                else {
                    return response()->json("El contacto con ID: " . $idContacto . " no existe.");
                }
            }
            else{
                return response()->json("La empresa con ID: " . $idEmpresa . " no existe.");
            }
        }
    }

    function eliminarContacto(Request $request){
        $idContacto = $request->idContacto;
        $contactos = DB::table('contactos')->where('idContacto', $idContacto)->update(['eliminado' => true]);
        if($contactos){
            return response()->json("Se eliminó el contacto correctamente.");
        }else {
            return response()->json("Ocurrió un error, por favor intentalo de nuevo.");
        }
    }
}
