<?php
namespace App\Services;

use App\Models\Products;

class StockService
{
    /**
     * Vérifie la disponibilité des produits en fonction de la quantité demandée.
     *
     * @param array $productsData
     * @return array Tableau contenant les erreurs de stock ou vide si tout est disponible
     */
    public function checkStock(array $productsData): array
    {
        $errors = [];

        foreach ($productsData as $productData) {
            $product = Products::find($productData['product_id']);

            // Vérifier que le produit existe
            if (!$product) {
                $errors[$productData['product_id']] = "Le produit ID {$productData['product_id']} est introuvable.";
                continue; // Passer au produit suivant
            }

            // Vérifier le stock
            if ($product->stockQuantity < $productData['quantity']) {
                $errors[$productData['product_id']] = "Le produit ID {$productData['product_id']} est en rupture de stock ou a une quantité insuffisante.";
            }
        }

        return $errors;
    }

    /**
     * Met à jour le stock des produits après la création de la commande.
     *
     * @param array $productsData
     * @return void
     */
    public function updateStock(array $productsData): void
    {
        foreach ($productsData as $productData) {
            // Lock the product row for update to prevent concurrent modifications
            $product = Products::where('id', $productData['product_id'])->lockForUpdate()->first();

            if ($product) {
                // Ensure there's enough stock before deducting
                if ($product->stockQuantity >= $productData['quantity']) {
                    $product->stockQuantity -= $productData['quantity'];
                    $product->save();
                } else {
                    // Optionally handle insufficient stock here
                    throw new \Exception("Stock insuffisant pour le produit ID {$productData['product_id']}.");
                }
            }
        }
    }
}
