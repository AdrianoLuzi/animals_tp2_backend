<?php

$per= [
    [
        "dni" => "45545924",
        "nom" => "Julio",
        "edad" => "22",
    ],
    [
        "dni" => "54545340",
        "nom" => "Fabian",
        "edad" => "20",
    ],
    [
        "dni" => "39823765",
        "nom" => "Juan",
        "edad" => "28",
    ],
    [
        "dni" => "40340212",
        "nom" => "Maria",
        "edad" => "27",
    ]
];

function listar(array $per){
    foreach($per as $perso){
        echo "DNI: " . $perso["dni"] . "\n";
        echo "Nombre: " . $perso["nom"] . "\n";
        echo "Edad: " . $perso["edad"] . "\n";
        echo "\n";
    }
}

//echo listar($per); 

//Busqueda secuencial por dni T1
function busDni(array $per,string $dni){
    foreach ($per as $perso){
        if ($perso["dni"] == $dni){
            $nom= $perso["nom"];
            return $nom;
        }
    }
}

//Ordenar por dni T2

function ordDni(array &$per){
    usort($per, function($a,$b){
        return (int) $a["dni"] - (int) $b["dni"];
    });
}

function busBin(array $per,string $num){
    $ini=0;
    $fin= count($per)- 1;
    while ($ini <= $fin){
        $med= intdiv($ini + $fin,2);
        if ($per[$med]["dni"] == (int) $num){
            return $per[$med]["nom"];
        } elseif((int)$num < $per[$med]["dni"]){
            $fin= $med - 1;
        } else{
            $ini = $med + 1;
        }
    }
}

//Busqueda secuencial por dni T3

function busNom(array $per, string $nom){
    foreach($per as $perso){
        if ($perso["nom"] == $nom){
            return $perso["dni"];
        }
    }
}

// t1 $dni = readline("Ingrese el dni a buscar: ");
// t1 echo busDni($per,$dni);

// t2 ordDni($per);
// t2 $dni = readline("Ingrese el dni a buscar: ");
// t2 echo busBin($per,$dni);

// t3 $nom = readline("Ingrese el nombre de la persona a buscar:");
// t3 echo busNom($per,$nom);