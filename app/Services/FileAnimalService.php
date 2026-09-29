<?php

namespace App\Services;

use App\Contracts\AnimalServiceInterface;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileAnimalService implements AnimalServiceInterface
{
    // Métodos auxiliares privados solicitados
    private function getAnimals(): array
    {
        // Verifica si el archivo existe en el disco local
        if (!Storage::disk('local')->exists('animals.json')) {
            return [];
        }
        
        $json = Storage::disk('local')->get('animals.json');
        // Transforma el string del archivo a un array asociativo
        return json_decode($json, true) ?? [];
    }

    private function saveAnimals(array $animals): void
    {
        // Guarda los datos con formato legible y ordenado
        $jsonContent = json_encode($animals, JSON_PRETTY_PRINT);
        Storage::disk('local')->put('animals.json', $jsonContent);
    }

    // Métodos públicos del contrato
    public function all(): array
    {
        return $this->getAnimals();
    }

    public function find(int|string $id)
    {
        $animals = $this->getAnimals();
        
        foreach ($animals as $animal) {
            if ($animal['id'] == $id) {
                return $animal;
            }
        }
        
        // Lanza una excepción estándar si el ID no existe[cite: 3]
        throw new Exception("El animal con ID {$id} no fue encontrado.");
    }

    public function create(array $data): array
    {
        $animals = $this->getAnimals();
        
        // Calcula el próximo ID autoincremental[cite: 3]
        $nextId = empty($animals) ? 1 : max(array_column($animals, 'id')) + 1;
        $data['id'] = $nextId;
        
        $animals[] = $data;
        $this->saveAnimals($animals);
        
        return $data;
    }

    public function delete(int|string $id): bool
    {
        $animals = $this->getAnimals();
        $initialCount = count($animals);
        
        $animals = array_filter($animals, function($animal) use ($id) {
            return $animal['id'] != $id;
        });
        
        if (count($animals) === $initialCount) {
            // Arroja excepción si no encuentra el ID a eliminar[cite: 3]
            throw new Exception("El animal con ID {$id} no fue encontrado.");
        }
        
        // array_values reordena los índices del array antes de guardar
        $this->saveAnimals(array_values($animals));
        return true;
    }

    public function reset(): void
    {
        // Limpia el archivo inicializándolo vacío[cite: 3]
        $this->saveAnimals([]);
    }
}