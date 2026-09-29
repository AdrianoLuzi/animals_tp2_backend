<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalDataRequest;

class WrongAnimalController extends Controller
{
    public function __construct()
    {
        if (! session()->has('animals')) {
            $key1 = uniqid();
            $key2 = uniqid();
            $key3 = uniqid();
            session([
                'animals' => [
                    $key1 => ['name' => 'Leo', 'species' => 'León', 'age' => 5],
                    $key2 => ['name' => 'Dora', 'species' => 'Elefante', 'age' => 10],
                    $key3 => ['name' => 'Nemo', 'species' => 'Pez Payaso', 'age' => 2],
                ],
            ]);
        }
    }

    public function index()
    {
        $animals = session('animals');

        return view('animals.index', ['animals' => $animals]);
    }

    public function create()
    {
        return view('animals.create');
    }

    public function update(AnimalDataRequest $request, $id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect()->route('animals.index')->with('error', 'Animal no encontrado');
        }

        $animals[$id] = $request->validated();
        session(['animals' => $animals]);

        return redirect()->route('animals.index')->with('success', 'Animal actualizado correctamente');
    }

    public function store(AnimalDataRequest $request)
    {
        $validatedData = $request->validated();
        $animals = session('animals');
        $nuevoId = uniqid(); // Genera un ID único
        $animals[$nuevoId] = $validatedData;
        session(['animals' => $animals]);

        return redirect()->route('animals.index')->with('success', 'Animal agregado correctamente');
    }

    public function edit($id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect()->route('animals.index')->with('error', 'Animal no encontrado');
        }

        return view('animals.edit', ['id' => $id, 'animal' => $animal]);
    }

    public function destroy($id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect()->route('animals.index')->with('error', 'Animal no encontrado');
        }

        unset($animals[$id]);

        session(['animals' => $animals]);

        return redirect()->route('animals.index')->with('success', 'Animal eliminado correctamente');
    }

    public function reset()
    {
        session()->forget('animals');

        return redirect()->route('animals.index')->with('warning', 'Sesión de animales reseteada correctamente');
    }
}
