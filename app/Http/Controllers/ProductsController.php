<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests\RequestProducts; // Assurez-vous d'importer la classe de requête
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ProductsController extends Controller
{
    /**
     * Afficher la liste des ressources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer tous les produits
        $products = Products::all();

        return response()->json($products, 200); // Code HTTP 200 : OK
    }

    /**
     * Stocker une nouvelle ressource dans le stockage.
     *
     * @param  \App\Http\Requests\RequestProducts  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestProducts $request)
    {
        // Créer une nouvelle instance de produit
        $product = Products::create($request->validated());

        // Retourner une réponse JSON avec un message de succès
        return response()->json([
            'message' => 'Produit créé avec succès',
            'product' => $product,
        ], 201); // Code HTTP 201 : Created
    }

    /**
     * Afficher la ressource spécifiée.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // Rechercher le produit par ID, ou échouer avec une exception
    try {
        $products = Products::findOrFail($id);

        return response()->json($products, 200); // Code HTTP 200 : OK
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Produit non trouvé'], 404); // Code HTTP 404 : Not Found
    }
    }

    /**
     * Mettre à jour la ressource spécifiée dans le stockage.
     *
     * @param  \App\Http\Requests\RequestProducts  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */


    public function update(RequestProducts $request, $id)
    {
        try {
            // Trouver le produit par son ID
            $product = Products::findOrFail($id);

            // Valider et mettre à jour les attributs du produit
            $formFields = $request->validated();
            $product->fill($formFields)->save();

            // Retourner une réponse JSON avec un message de succès
            return response()->json([
                'message' => 'Produit mis à jour avec succès',
                'product' => $product,
            ], 200); // Code HTTP 200 : OK

        } catch (ModelNotFoundException $e) {
            // Gérer le cas où l'ID du produit n'est pas trouvé
            return response()->json([
                'message' => 'Produit non trouvé',
            ], 404); // Code HTTP 404 : Not Found
        }
    }

    /**
     * Supprimer la ressource spécifiée du stockage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    try {
        // Recherche le produit par id
        $product = Products::findOrFail($id);

        // Supprimer le produit
        $product->delete();

        // Retourner une réponse JSON avec un message de succès
        return response()->json([
            'message' => 'Produit supprimé avec succès',
        ], 200); // Code HTTP 200 : OK

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'message' => 'Produit non trouvé',
        ], 404); // Code HTTP 404 : Not Found
    }
}

}
