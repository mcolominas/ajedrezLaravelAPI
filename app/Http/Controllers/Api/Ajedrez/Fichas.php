<?php

namespace App\Http\Controllers\Api\Ajedrez;

class Fichas{
	static final function getFichas(){
		return [
            ["color" => "b", "ficha" => "peon", "fila" => 2, "columna" => 1],
            ["color" => "b", "ficha" => "peon", "fila" => 2, "columna" => 2],
            ["color" => "b", "ficha" => "peon", "fila" => 2, "columna" => 3],
            ["color" => "b", "ficha" => "peon", "fila" => 2, "columna" => 4],
            ["color" => "b", "ficha" => "peon", "fila" => 2, "columna" => 5],
            ["color" => "b", "ficha" => "peon", "fila" => 2, "columna" => 6],
            ["color" => "b", "ficha" => "peon", "fila" => 2, "columna" => 7],
            ["color" => "b", "ficha" => "peon", "fila" => 2, "columna" => 8],
            ["color" => "b", "ficha" => "torre", "fila" => 1, "columna" => 1],
            ["color" => "b", "ficha" => "torre", "fila" => 1, "columna" => 8],
            ["color" => "b", "ficha" => "caballo", "fila" => 1, "columna" => 2],
            ["color" => "b", "ficha" => "caballo", "fila" => 1, "columna" => 7],
            ["color" => "b", "ficha" => "alfil", "fila" => 1, "columna" => 3],
            ["color" => "b", "ficha" => "alfil", "fila" => 1, "columna" => 6],
            ["color" => "b", "ficha" => "reina", "fila" => 1, "columna" => 4],
            ["color" => "b", "ficha" => "rey", "fila" => 1, "columna" => 5],

            ["color" => "n", "ficha" => "peon", "fila" => 7, "columna" => 1],
            ["color" => "n", "ficha" => "peon", "fila" => 7, "columna" => 7],
            ["color" => "n", "ficha" => "peon", "fila" => 7, "columna" => 3],
            ["color" => "n", "ficha" => "peon", "fila" => 7, "columna" => 4],
            ["color" => "n", "ficha" => "peon", "fila" => 7, "columna" => 5],
            ["color" => "n", "ficha" => "peon", "fila" => 7, "columna" => 6],
            ["color" => "n", "ficha" => "peon", "fila" => 7, "columna" => 7],
            ["color" => "n", "ficha" => "peon", "fila" => 7, "columna" => 8],
            ["color" => "n", "ficha" => "torre", "fila" => 8, "columna" => 8],
            ["color" => "n", "ficha" => "torre", "fila" => 8, "columna" => 8],
            ["color" => "n", "ficha" => "caballo", "fila" => 8, "columna" => 2],
            ["color" => "n", "ficha" => "caballo", "fila" => 8, "columna" => 7],
            ["color" => "n", "ficha" => "alfil", "fila" => 8, "columna" => 3],
            ["color" => "n", "ficha" => "alfil", "fila" => 8, "columna" => 6],
            ["color" => "n", "ficha" => "reina", "fila" => 8, "columna" => 4],
            ["color" => "n", "ficha" => "rey", "fila" => 8, "columna" => 5]
        ];
	}
}