<?php

namespace App\Services;

use App\Contracts\AnimalServiceInterface;
use App\Exceptions\AnimalNotFoundException;

class SessionAnimalService implements AnimalServiceInterface
{
    public function all(): array
    {
        return session('animals', []);
    }

    public function find(string $id): ?array
    {
        $animals = session('animals', []);
        if (!isset($animals[$id])) {
            throw AnimalNotFoundException::forId($id);
        }
        return $animals[$id] ?? null;
    }

    public function create(array $data): array
    {
        $animals = session('animals', []);
        $newId = uniqid();
        $animals[$newId] = $data;
        session(['animals' => $animals]);
        return ['id' => $newId] + $data;
    }

    public function update(string $id, array $data): ?array
    {
        $animals = session('animals', []);
        if (!isset($animals[$id])) {
            throw new \Exception("El animal con ID \"$id\" no fue encontrado.");
        }
        $animals[$id] = $data;
        session(['animals' => $animals]);
        return ['id' => $id] + $data;
    }

    public function delete(string $id): bool
    {
        $animals = session('animals', []);
        if (!isset($animals[$id])) {
            throw new \Exception("El animal con ID \"$id\" no fue encontrado.");
        }
        unset($animals[$id]);
        session(['animals' => $animals]);
        return true;
    }

    public function reset(): void
    {
        session()->forget('animals');
    }
}