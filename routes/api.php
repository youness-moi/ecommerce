<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', [AuthController::class, 'login']);
Route::get('user', [AuthController::class, 'getAuthenticatedUser'])->middleware('auth:api');


Route::apiResource('products', ProductsController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('orders', OrderController::class)->middleware('auth:api'); // Route pour ajouter un produit au panierresource('orders', OrderController::class)->middleware('auth:api');

// route pour ajouter un produit au panier

Route::prefix('cart')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CartController::class, 'index']); // Afficher le contenu du panier
    Route::post('/add', [CartController::class, 'add']); // Ajouter un produit
    Route::put('/update/{product}', [CartController::class, 'update']); // Modifier la quantité d'un produit
    Route::delete('/remove/{product}', [CartController::class, 'remove']); // Supprimer un produit du panier
    Route::post('/clear', [CartController::class, 'clear']); // Vider le panier
});


