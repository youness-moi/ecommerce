<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Jobs\ProcessOrder;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\OrderErrorHandler;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupération de toutes les commandes pour l'utilisateur authentifié
        $orders = Orders::where('user_id', auth()->id())->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @param  StockService  $stockService
     * @param  OrderErrorHandler  $errorHandler
     * @return \Illuminate\Http\Response
     */
    public function store( StoreOrderRequest $request)
    {
        $formFields = $request->validated();

        // Déclencher le Job pour traiter la commande
        ProcessOrder::dispatchSync($formFields);

        return response()->json(['status' => 'Commande created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        // Vérifier si l'utilisateur authentifié a accès à cette commande
        if ($orders->user_id !== auth()->id()) {
            return response()->json(['message' => 'Commande non trouvée.'], 404);
        }

        return response()->json($orders);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        // Vérifier si l'utilisateur authentifié a accès à cette commande
        if ($orders->user_id !== auth()->id()) {
            return response()->json(['message' => 'Commande non trouvée.'], 404);
        }

        // Validation des données du formulaire
        $validatedData = $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled', // Exemple de validation pour le statut
        ]);

        // Mettre à jour le statut de la commande
        $orders->update($validatedData);

        return response()->json(['message' => 'Commande mise à jour avec succès.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        // Vérifier si l'utilisateur authentifié a accès à cette commande
        if ($orders->user_id !== auth()->id()) {
            return response()->json(['message' => 'Commande non trouvée.'], 404);
        }

        // Supprimer les items de la commande
        $orders->orderItems()->delete();

        // Supprimer la commande
        $orders->delete();

        return response()->json(['message' => 'Commande supprimée avec succès.']);
    }
}
