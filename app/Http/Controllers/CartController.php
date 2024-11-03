<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService; // Assurez-vous que CartService gère la logique du panier

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        // Suppose que vous récupérez le panier de l'utilisateur authentifié
        $user = $request->user();
        $cartItems = $user->carts()->with('product')->get();

        dd($cartItems); // Pour vérifier directement le contenu des articles du panier

        return response()->json($cartItems);
    }

    public function add(Request $request)
    {
        $this->cartService->addItem($request->product_id, $request->quantity);
        return response()->json(['message' => 'Produit ajouté au panier']);
    }

    public function update(Request $request, $productId)
    {
        $this->cartService->updateItem($productId, $request->quantity);
        return response()->json(['message' => 'Quantité mise à jour']);
    }

    public function remove($productId)
    {
        $this->cartService->removeItem($productId);
        return response()->json(['message' => 'Produit supprimé du panier']);
    }

    public function clear()
    {
        $this->cartService->clear();
        return response()->json(['message' => 'Panier vidé']);
    }
}
