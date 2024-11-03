<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Autoriser la requête. Vous pouvez ajouter des conditions personnalisées si nécessaire.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $this->user,
            'password' => 'tring|min:8|confirmed',


        ];
    }

    /**
     * Personnaliser les messages d'erreur.
     *
     * @return array
     */
    public function messages()
    {
        return [

            'email.email' => "Le format de l'email est invalide.",
            'email.unique' => "Cet email est déjà utilisé.",

            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
      //  la requête attend JSON, renvoie une réponse JSON
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422));



    }
}
