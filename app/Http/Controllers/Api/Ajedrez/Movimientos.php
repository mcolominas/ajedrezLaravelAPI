<?php

namespace App\Http\Controllers\Api\Ajedrez;

use App\Ficha;

class Movimientos{

	public static function checkMovimiento(Ficha $ficha, $to){
        switch ($ficha->tipo) {
            case 'rey':
                return Movimientos::rey($ficha, $to);
            	break;
            case 'reina':
                return Movimientos::reina($ficha, $to);
                break;
            case 'torre':
                return Movimientos::torre($ficha, $to);
                break;
            case 'alfil':
                return Movimientos::alfil($ficha, $to);
                break;
            case 'caballo':
                return Movimientos::caballo($ficha, $to);
                break;
            case 'peon':
                return Movimientos::peon($ficha, $to);
                break;
        }
        return false;
    }

	private static function rey(Ficha $ficha, $to){
		$num1 = $ficha->fila - $to['fila'];
		$num2 = $ficha->columna - $to['columna'];
		return ($num1 > -2 && $num1 < 2 && $num2 > -2 && $num2 < 2);
	}
	private static function reina(Ficha $ficha, $to){
		return true;	
	}
	private static function alfil(Ficha $ficha, $to){
		return true;	
	}
	private static function torre(Ficha $ficha, $to){
        return ($ficha->fila != $to['fila'] && $ficha->columna == $to['columna']) || ($ficha->fila == $to['fila'] && $ficha->columna != $to['columna']);
	}
	private static function caballo(Ficha $ficha, $to){
		return true;	
	}
	private static function peon(Ficha $ficha, $to){
		return true;	
	}
}