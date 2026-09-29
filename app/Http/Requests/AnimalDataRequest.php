<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AnimalDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => Str::title(trim($this->input('name'))),
            ]);
        }

        if ($this->has('species')) {
            $this->merge([
                'species' => Str::lower(trim($this->input('species'))),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'species' => 'required|string|in:león,elefante,pez payaso,gato,perro,conejo,caballo,oso,pájaro,tortuga',
            'age' => 'required|integer|min:3|max:30',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de :max caracteres.',
            'species.required' => 'La especie es obligatoria.',
            'species.string' => 'La especie debe ser una cadena de texto.',
            'species.in' => 'La especie ":input" no es válida. Puede ser: :values.',
            'age.required' => 'La edad es obligatoria.',
            'age.integer' => 'La edad debe ser un número entero.',
            'age.min' => 'La edad debe ser al menos :min años.',
            'age.max' => 'La edad no puede ser mayor a :max años.',
        ];
    }
}
