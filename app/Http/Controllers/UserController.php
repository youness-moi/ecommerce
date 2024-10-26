<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Utilisation de la pagination pour améliorer la performance
        $users = User::paginate(10);
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $formFields = $request->validated();

            $formFields['password'] = Hash::make($request->input('password')); // Hash du mot de passe

            $user = User::create($formFields);

            DB::commit();
            return response()->json($user, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'User could not be created', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // make sure the user exists and try catching it
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            // Validation des données du formulaire
            $formFields = $request->validated();

            // Si un nouveau mot de passe est fourni, on le hache
            if ($request->filled('password')) {
                $formFields['password'] = Hash::make($request->input('password'));
            } else {
                // Si le mot de passe n'est pas envoyé, on le retire des champs à mettre à jour
                unset($formFields['password']);
            }

            // Mise à jour des informations de l'utilisateur
            $user->fill($formFields)->save();

            DB::commit();

            return response()->json(['message' => 'User has been updated'], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'User could not be updated', 'details' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
            return response()->json(['message' => 'User has been deleted'], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['error' => 'User could not be deleted', 'details' => "user is not found"], 500);
        }
    }
}
