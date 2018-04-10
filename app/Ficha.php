<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    protected static function insertar($idPartida, $color, $tipoFicha, $fila, $columna){
        $ficha = new Ficha;
        $ficha->id_partida = $idPartida;
        $ficha->color = $color;
        $ficha->tipo = $tipoFicha;
        $ficha->fila = $fila;
        $ficha->columna = $columna;
        if($ficha->save()) return $ficha;
        else return false;
    }
}
