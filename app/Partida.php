<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    //
    protected static function insertar($id_jugador_negro, $id_jugador_blanco){
        $partida = new Partida();
        $partida->id_jugador_negro=$id_jugador_negro;
        $partida->id_jugador_blanco=$id_jugador_blanco;
        if($partida->save()) return $partida;
        else return false;
    }
}
