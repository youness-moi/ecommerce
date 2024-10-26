<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize()
    {
        return true; // Remplacer par les autorisations si nécessaire
    }

    /**
     * Règles de validation de la requête.
     */
    public function rules()
    {
        return [
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'products.required' => 'Les produits sont requis.',
            'products.*.product_id.required' => 'L\'ID du produit est requis.',
            'products.*.product_id.exists' => 'Le produit sélectionné n\'existe pas.',
            'products.*.quantity.required' => 'La quantité est requise.',
            'products.*.quantity.integer' => 'La quantité doit être un nombre entier.',
            'products.*.price.required' => 'Le prix est requis.',
            'products.*.price.numeric' => 'Le prix doit être un nombre.',
            'products.*.discount.numeric' => 'Le discount doit être un nombre.',
        ];
    }

    /**
     * Retourne une réponse JSON en cas d'échec de la validation.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
