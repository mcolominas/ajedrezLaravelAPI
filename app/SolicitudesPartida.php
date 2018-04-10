<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudesPartida extends Model
{
    //
    protected $table = "solicitudesPartidas";

    protected static function insertar($id_usuario1, $id_usuario2){
        $solicitudesPartida = new SolicitudesPartida;
    	$solicitudesPartida->id_usuario1 = $id_usuario1;
    	$solicitudesPartida->id_usuario2 = $id_usuario2;
    	if($solicitudesPartida->save()) return $solicitudesPartida;
    	else return false;
    }
}
