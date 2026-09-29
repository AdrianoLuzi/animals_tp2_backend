@extends('layouts.animals')

@section('content')
    <h1 class="text-2xl font-bold text-white mb-6 text-center">Listado de Animales</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($animals as $id => $animal)
            @php
                $especie = strtolower($animal['species']);
                $icono = '🐾';
                if (str_contains($especie, 'león') || str_contains($especie, 'leon')) {
                    $icono = '🦁';
                } elseif (str_contains($especie, 'elefante')) {
                    $icono = '🐘';
                } elseif (str_contains($especie, 'pez')) {
                    $icono = '🐟';
                } elseif (str_contains($especie, 'perro')) {
                    $icono = '🐶';
                } elseif (str_contains($especie, 'gato')) {
                    $icono = '🐱';
                }elseif (str_contains($especie, 'loro') || str_contains($especie, 'ave') || str_contains($especie, 'pájaro') || str_contains($especie, 'pajaro')) {
                    $icono = '🦜';
                }
            @endphp

            <div class="bg-slate-800 rounded-lg shadow p-4 text-white border border-slate-700">
                <div class="flex items-start justify-between">
                    <h2 class="text-lg font-semibold border border-slate-500 rounded px-2 py-1">
                        {{ $animal['name'] }}
                    </h2>
                    <span class="text-3xl">{{ $icono }}</span>
                </div>

                <p class="text-slate-400 mt-2">{{ $animal['species'] }} - {{ $animal['age'] }} años</p>

                <div class="flex gap-3 mt-3">
                    <a href="{{ route('animals.edit', $id) }}" class="text-blue-400 hover:underline">
                        Editar
                    </a>

                    <form action="{{ route('animals.destroy', $id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:underline" onclick="return confirm('¿Seguro que querés eliminar este animal?')">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-8 gap-4">
        <a href="{{ route('animals.create') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
            + Agregar Animal
        </a>
        <form action="{{ route('animals.reset') }}" method="POST" class="inline">
            @csrf
            @method('POST')
            <button type="submit" class="inline-block bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700" onclick="return confirm('¿Seguro que querés resetear los datos?')">
                Resetear Sesión
            </button>
        </form>
    </div>
@endsection