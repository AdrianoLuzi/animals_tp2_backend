<?php

// Ejemplo de una función simple
function saludar(string $nombre) {
    return "Hola, " . $nombre . "!";
}

function despedir(string $nombre) {
    return "Chau, " . $nombre . "!";
}

// Ejemplo de una función con parámetros opcionales
function calcularArea(float $base, ?float $altura = null) {
    if ($altura === null) {
        $altura = $base;
    }
    return $base * $altura;
}

function porcentaje(int $num,int $nume){
    $por=0;
    $por= ($num * $nume) / 100;
    return $por;
}

// Llamada a la función saludar
echo saludar("Juan") . "\n";

// Llamada a la función calcularArea con ambos parámetros
// echo "Área del rectángulo: " . calcularArea(5, 10) . "\n";

// Llamada a la función calcularArea con solo el parámetro base, usando el valor por defecto para altura
// echo "Área del cuadrado: " . calcularArea(4) . "\n";

// Llamada a la funcion porcentaje
echo porcentaje(30,100) . "\n";

// Llamada a ala funcion despedir
echo despedir("Juan") . "\n";