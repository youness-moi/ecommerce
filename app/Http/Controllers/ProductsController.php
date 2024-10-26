<?php
namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests\RequestProducts;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductsController extends Controller
{
    /**
     * Afficher la liste des produits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Utilisation de la pagination pour une meilleure performance
        $products = Products::paginate(10);

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
        DB::beginTransaction();
        try {
            // Créer un nouveau produit avec les données validées
            $product = Products::create($request->validated());

            DB::commit();
            return response()->json([
                'message' => 'Produit créé avec succès',
                'product' => $product,
            ], 201); // Code HTTP 201 : Created

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erreur lors de la création du produit',
                'details' => $e->getMessage(),
            ], 500); // Code HTTP 500 : Erreur serveur
        }
    }

    /**
     * Afficher un produit spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // Rechercher le produit par ID
            $product = Products::findOrFail($id);

            return response()->json($product, 200); // Code HTTP 200 : OK

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Produit non trouvé'], 404); // Code HTTP 404 : Not Found
        }
    }

    /**
     * Mettre à jour un produit spécifique.
     *
     * @param  \App\Http\Requests\RequestProducts  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestProducts $request, $id)
    {
        DB::beginTransaction();
        try {
            // Trouver le produit par son ID
            $product = Products::findOrFail($id);

            // Valider et mettre à jour les champs du produit
            $product->update($request->validated());

            DB::commit();
            return response()->json([
                'message' => 'Produit mis à jour avec succès',
                'product' => $product,
            ], 200); // Code HTTP 200 : OK

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Produit non trouvé'], 404); // Code HTTP 404 : Not Found
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erreur lors de la mise à jour du produit',
                'details' => $e->getMessage(),
            ], 500); // Code HTTP 500 : Erreur serveur
        }
    }

    /**
     * Supprimer un produit spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Trouver le produit par son ID
            $product = Products::findOrFail($id);

            // Supprimer le produit
            $product->delete();

            DB::commit();
            return response()->json(['message' => 'Produit supprimé avec succès'], 200); // Code HTTP 200 : OK

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Produit non trouvé'], 404); // Code HTTP 404 : Not Found
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erreur lors de la suppression du produit',
                'details' => $e->getMessage(),
            ], 500); // Code HTTP 500 : Erreur serveur
        }
    }
}
