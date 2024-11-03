<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user,
            'password' => 'string|min:8|confirmed',
            'password_confirmation' =>'same:password',

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
            'name.required' => 'Le nom est requis.',
            'email.required' => "L'email est requis.",
            'email.email' => "Le format de l'email est invalide.",
            'email.unique' => "Cet email est déjà utilisé.",
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role.required' => 'Le rôle est requis.',
            'role.in' => 'Le rôle doit être soit utilisateur, administrateur ou livreur.',
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
