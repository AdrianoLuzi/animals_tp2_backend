@extends('layouts.animals')

@section('content')
    <h1 class="text-2xl font-bold text-white mb-6">Editar Animal</h1>

    <form action="{{ route('animals.update', $id) }}" method="POST" class="bg-slate-800 rounded-lg shadow p-6 max-w-md text-white">
        @csrf
        @method('PUT')

        <label for="name" class="block text-sm font-medium mb-1">Nombre</label>
        <input type="text" id="name" name="name" value="{{ $animal['name'] }}"
                value="{{ old('name', $animal['name']) }}"
               class="w-full border-gray-300 rounded-md shadow-sm mb-4 p-2 border text-black">
        @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <label for="species" class="block text-sm font-medium mb-1">Especie</label>
        <input type="text" id="species" name="species" value="{{ $animal['species'] }}"
                value="{{ old('species') }}"
               class="w-full border-gray-300 rounded-md shadow-sm mb-4 p-2 border text-black">
        @error('species')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <label for="age" class="block text-sm font-medium mb-1">Edad</label>
        <input type="number" id="age" name="age" value="{{ $animal['age'] }}"
                value="{{ old('age', $animal['age']) }}"
               class="w-full border-gray-300 rounded-md shadow-sm mb-4 p-2 border text-black">
        @error('age')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Actualizar
        </button>
    </form>
@endsection