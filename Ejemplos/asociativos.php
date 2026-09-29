<?php

// Ejemplo de arreglo asociativo
$personas = [
    [
        "dni"       => "12345678",
        "nombre"    => "Juan",
        "edad"      => 30,
        "ciudad"    => "San Juan"
    ],
    [
        "dni"       => "87654321",
        "nombre"    => "María",
        "edad"      => 25,
        "ciudad"    => "Mendoza"
    ]
];

function agregarPersona(array &$personas, array $persona)
{
    $personas[] = $persona;
}

function listarPersonas(array $personas)
{
    foreach ($personas as $persona) {
        echo "DNI: " . $persona["dni"] . "\n";
        echo "Nombre: " . $persona["nombre"] . "\n";
        echo "Edad: " . $persona["edad"] . "\n";
        echo "Ciudad: " . $persona["ciudad"] . "\n";
        echo "\n"; // Línea en blanco para separar cada persona
    }
}

// Llamada a la función para agregar una nueva persona
agregarPersona($personas, [
    "dni" => "11223344",
    "nombre" => "Carlos",
    "edad" => 28,
    "ciudad" => "Buenos Aires"
]);

// Llamada a la función para listar todas las personas
listarPersonas($personas);


// Tarea 1: Crear una función que haga búsqueda secuencial por DNI,
// Tarea 2: Crear una función que haga búsqueda binaria por DNI,
// Tarea 3: Crear una función que haga búsqueda secuencial por nombre,