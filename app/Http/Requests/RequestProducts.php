<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RequestProducts extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Autoriser toutes les requêtes, vous pouvez personnaliser selon vos besoins
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:1',
            'price' => 'required|numeric|gt:0', // Nombre supérieur à 0
            'description' => 'nullable|string|max:500', // Optionnel, max 500 caractères
            'stockQuantity' => 'required|integer|gte:0', // Doit être un entier supérieur ou égal à 0
            'size' => 'required|string',
            'color' => 'required|string',
            'material' => 'nullable|string',
            'gender' => 'required|string',
            'category_id' => 'required|integer|gt:0', // Doit être un entier supérieur à 0
        ];
    }

    /**
     * Obtenir les messages de validation personnalisés.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'price.required' => 'Le prix est obligatoire.',
            'price.gt' => 'Le prix doit être supérieur à 0.',
            'price.required' => 'Le prix est obligatoire',
            'description.max' => 'La description ne peut pas dépasser 500 caractères.',
            'stockQuantity.required' => 'La quantité en stock est obligatoire.',
            'stockQuantity.gte' => 'La quantité en stock doit être supérieure ou égale à 0.',
            'category_id.required' => 'L\'ID de la catégorie est obligatoire.',
            'category_id.gt' => 'L\'ID de la catégorie doit être supérieur à 0.',
        ];
    }

    /**
     * Gérer les erreurs de validation.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Erreur de validation',
            'errors' => $validator->errors(),
        ], 422)); // Code HTTP 422 : Unprocessable Entity
    }
}
