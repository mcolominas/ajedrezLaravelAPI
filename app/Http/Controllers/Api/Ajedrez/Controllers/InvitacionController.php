<?php

namespace App\Http\Controllers\Api\Ajedrez\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Ajedrez\Master;
use App\Http\Controllers\Api\Ajedrez\Fichas;
use App\SolicitudesPartida;
use App\Partida;
use App\Ficha;

class InvitacionController extends Master
{
    function invitar(Request $request){
    	$userID1 = $this->getIdUserFromToken($request->input('token'));
    	$userID2 = $this->getIdUserFromName($request->input('name'));

    	$status = 0;
    	if($userID1 != false && $userID2 != false){
    		if(SolicitudesPartida::where([["id_usuario1", $userID1], ["id_usuario2", $userID2]])->orWhere([["id_usuario1", $userID2], ["id_usuario2", $userID1]])->count() == 0){
    			$solicitudesPartida = new SolicitudesPartida;
		    	$solicitudesPartida->id_usuario1 = $userID1;
		    	$solicitudesPartida->id_usuario2 = $userID2;
		    	$solicitudesPartida->save();
		    	$status = 1;
		    	$mensaje="Se ha enviado una peticion para jugar.";
    		}else $mensaje="Esperando a que el usuario acepta la peticion";
    	}else $mensaje="No se ha podido obtener el usuario";
    	return response(json_encode(["status" => $status, "mensaje" => $mensaje]), 200)->header('Content-Type', 'application/json');
    }

    function ver(Request $request){
    	$id_usuario = $this->getIdUserFromToken($request->input('token'));
    	$status = 0;
    	if($id_usuario != false){
    		$status = 1;
    		$mensaje = SolicitudesPartida::from('users as u1')
    			->join('solicitudesPartidas as sp', function($join){
                    $join->on('u1.id', '=', 'sp.id_usuario2');
                })->join('users as u2', function($join){
                    $join->on('u2.id', '=', 'sp.id_usuario1');
                })->where('u1.id', $id_usuario)
    			->select("u2.name")
    			->get()
    			->toArray();

    	}else $mensaje="No se ha podido obtener el usuario";

    	return response(json_encode(["status" => $status, "mensaje" => $mensaje]), 200)->header('Content-Type', 'application/json');
    }

    function responder(Request $request){
        $userID1 = $this->getIdUserFromToken($request->input('token'));
        $userID2 = $this->getIdUserFromName($request->input('name'));
        $respuesta = $request->input('respuesta');
        $status = 0;
        if($userID1 != false && $userID2 != false){
            if($respuesta == 1){
                $status = 1;
                SolicitudesPartida::where([["id_usuario1", $userID2],["id_usuario2", $userID1]])->delete();

                $partida = new Partida();
                $partida->id_jugador_negro=$userID2;
                $partida->id_jugador_blanco=$userID1;
                $partida->save();

                $this->generarTablero($partida->id);

                $mensaje = "Solicitud aceptada";

            }else if($respuesta == 0){
                $status = 2;
                SolicitudesPartida::where([["id_usuario1", $userID2],["id_usuario2", $userID1]])->delete();
                $mensaje = "Solicitud rechazada";
            }else $mensaje = "Respuesta no valida.";
        }else $mensaje="No se ha podido obtener el usuario";
        
        return response(json_encode(["status" => $status, "mensaje" => $mensaje]), 200)->header('Content-Type', 'application/json');
    }

    private function generarTablero($idPartida){
        foreach (Fichas::getFichas() as $ficha) {
            $this->insertarFicha($idPartida, $ficha['color'], $ficha['ficha'], $ficha['fila'], $ficha['columna']);
        }
    }

    private function insertarFicha($idPartida, $color, $tipoFicha, $fila, $columna){
        $ficha = new Ficha;
        $ficha->id_partida = $idPartida;
        $ficha->color = $color;
        $ficha->tipo = $tipoFicha;
        $ficha->fila = $fila;
        $ficha->columna = $columna;
        return $ficha->save();
    }
}
