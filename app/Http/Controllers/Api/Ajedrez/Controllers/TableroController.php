<?php

namespace App\Http\Controllers\Api\Ajedrez\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Ajedrez\Movimientos;
use App\User;
use App\Partida;
use App\Ficha;

class TableroController extends Controller
{
    function ver(Request $request){
        $userID1 = User::getIdUserFromToken($request->input('token'));
        $userID2 = User::getIdUserFromName($request->input('name'));

        $status = 0;
        if($userID1 != false && $userID2 != false){
            $partida = Partida::select("id")->where([["id_jugador_negro", $userID1],["id_jugador_blanco", $userID2]])->orWhere([["id_jugador_negro", $userID2],["id_jugador_blanco", $userID1]]);
            if($partida->count() > 0){
                $status = 1;
                $idPartida = $partida->first()->toArray()["id"];
                $fichas = Ficha::select("color", "tipo", "fila", "columna")->where("id_partida", $idPartida)->get()->toArray();
            }else $mensaje = "No se ha encontrado la partida.";
            
        }else $mensaje="No se ha podido obtener el usuario";
        
        if($status)
            return response(json_encode(["status" => $status, "tablero" => $fichas]), 200)->header('Content-Type', 'application/json')->header('Access-Control-Allow-Origin', '*');
        else
            return response(json_encode(["status" => $status, "mensaje" => $mensaje]), 200)->header('Content-Type', 'application/json')->header('Access-Control-Allow-Origin', '*');
    }

    function contrincantes(Request $request){
        $userID1 = User::getIdUserFromToken($request->input('token'));

        $status = 0;

        if($userID1 != false){
            $status = 1;
            $listaID1 = Partida::select("id_jugador_blanco as id")->where("id_jugador_negro", $userID1)->get()->toArray();
            $listaID2 =Partida::select("id_jugador_negro as id")->where("id_jugador_blanco", $userID1)->get()->toArray();
            $listaIDs = array_merge($listaID1, $listaID2);

            $mensaje = [];
            foreach ($listaIDs as $value) {
                $name = User::select("name")->where("id", $value['id'])->first()->toArray();
                $mensaje[] = $name;
            }

            
        }else $mensaje="No se ha podido obtener el usuario";

        return response(json_encode(["status" => $status, "mensaje" => $mensaje]), 200)->header('Content-Type', 'application/json')->header('Access-Control-Allow-Origin', '*');

    }

    function moverFicha(Request $request){
        $userID1 = User::getIdUserFromToken($request->input('token'));
        $userID2 = User::getIdUserFromName($request->input('name'));
        $toFila = $request->input('toFila');
        $toColumna = $request->input('toColumna');
        $fromFila = $request->input('fromFila');
        $fromColumna = $request->input('fromColumna');
        
        $status = 0;

        if($userID1 != false && $userID2 != false){
            $partida = Partida::select("id", "turno", "id_jugador_negro", "id_jugador_blanco")
                        ->where([["id_jugador_negro", $userID1], ["id_jugador_blanco", $userID2]])
                        ->orWhere([["id_jugador_negro", $userID2], ["id_jugador_blanco", $userID1]]);
            
            if($partida->count() == 1){
                $partida = $partida->first();
                
                if(($partida->turno === "n" && $partida->id_jugador_negro == $userID1) || 
                   ($partida->turno === "b" && $partida->id_jugador_blanco == $userID1)){
                    $ficha = Ficha::where([["id_partida", $partida->id], ["fila", $toFila], ["columna", $toColumna], ["color", $partida->turno]]);
                    if($ficha->count() == 1){
                        if(Movimientos::checkMovimiento($ficha->first(), ["columna" => $fromColumna, "fila" => $fromFila])){
                            $fichaTarget = Ficha::where([["id_partida", $partida->id], ["fila", $fromFila], ["columna", $fromColumna]]);

                            if($fichaTarget->count() > 0){
                                $fichaMia = $fichaTarget->first()->color === $partida->turno;
                                if(!$fichaMia) $fichaTarget->delete();
                            }else $fichaMia = false;

                            //Fin partida
                            if(Ficha::where([["id_partida", $partida->id], ["color", ($partida->turno === "n" ? "b" : "n")], ["tipo", "rey"]])->count()==0){
                                $status = 2;
                                $mensaje = "Fin partida, el ganador es el jugador ". ($partida->turno === "b" ? "blanco" : "negro");

                                Ficha::where("id_partida", $partida->id)->delete();
                                $partida->delete();

                            //Mover Ficha
                            }else if(!$fichaMia){
                                $status = 1;

                                $ficha = $ficha->first();
                                $ficha->columna = $fromColumna;
                                $ficha->fila = $fromFila;
                                $ficha->save();

                                $partida->turno = ($partida->turno === "n" ? "b" : "n");
                                $partida->save();

                                $mensaje="ficha movida";
                            }else $mensaje="No puedes mover tu ficha a un lugar donde ya hay otra ficha tuya";
                        }else $mensaje="Movimiento no valido.";
                    }else if($ficha->count() > 1) $mensaje="Se ha encontrado mas de 1 ficha en la misma casilla.";
                    else $mensaje="No hay ninguna ficha tuya en la casilla seleccionada.";
                }else $mensaje = "No es tu turno.";
            }else $mensaje = "No se ha encontrado la partida.";
        }else $mensaje="No se ha podido obtener el usuario";
        
        return response(json_encode(["status" => $status, "mensaje" => $mensaje]), 200)->header('Content-Type', 'application/json')->header('Access-Control-Allow-Origin', '*');
    }
}
