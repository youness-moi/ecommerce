<?php

namespace Tests\Feature;

use App\Models\Categories;
use Tests\TestCase;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase; // Permet de rafraîchir la base de données après chaque test

    /**
     * Test de l'index des produits.
     *
     * @return void
     */
    public function test_can_list_products()
    {
        // Créer quelques produits
        Products::factory()->count(3)->create();


        // Effectuer une requête GET sur la route index
        $response = $this->getJson(route('products.index'));

        // Vérifier que la réponse est OK et contient les produits
        $response->assertStatus(200)
                 ->assertJsonCount(3); // On s'attend à 3 produits
    }

    /**
     * Test de la création d'un produit.
     *
     * @return void
     */
    public function test_can_create_product()
    {
        // Créer un jeu de données valides
        $productData = Products::factory()->make()->toArray();

        // Effectuer une requête POST sur la route de création
        $response = $this->postJson(route('products.store'), $productData);

        // Vérifier que le produit est bien créé et qu'on a une réponse 201
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Produit créé avec succès',
                 ]);

        // Vérifier que le produit existe dans la base de données
        $this->assertDatabaseHas('products', $productData);
    }

    /**
     * Test de l'affichage d'un produit spécifique.
     *
     * @return void
     */
    public function test_can_show_product()
    {
        // Créer un produit
        $product = Products::factory()->create();

        // Effectuer une requête GET pour afficher le produit
        $response = $this->getJson(route('products.show', $product->id));

        // Vérifier que la réponse contient le produit
        $response->assertStatus(200)
                 ->assertJson($product->toArray());
    }

    /**
     * Test de l'affichage d'un produit non trouvé.
     *
     * @return void
     */
    public function test_show_product_not_found()
    {
        // Effectuer une requête GET pour un produit non existant
        $response = $this->getJson(route('products.show', 9999)); // ID inexistant

        // Vérifier que la réponse est une 404
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Produit non trouvé',
                 ]);
    }

    /**
     * Test de la mise à jour d'un produit.
     *
     * @return void
     */
    public function can_update_product()
    {
        // Create a product using the factory
        $product = Products::factory()->create();

        // Define updated data, including all required fields
        $updatedData = [
            'name' => 'Updated Product Name',
            'price' => 99.99,
            'stockQuantity' => 50,  // Required field
            'size' => 'L',           // Required field
            'color' => 'Blue',       // Required field
            'gender' => 'Male',      // Required field
            'category_id' => Categories::factory()->create()->id,  // Required category ID
        ];

        // Perform a PUT request to update the product
        $response = $this->putJson(route('products.update', $product->id), $updatedData);

        // Verify the update was successful
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Produit mis à jour avec succès',
                 ]);
    }


    /**
     * Test de la suppression d'un produit.
     *
     * @return void
     */
    public function test_can_delete_product()
    {
        // Créer un produit
        $product = Products::factory()->create();

        // Effectuer une requête DELETE pour supprimer le produit
        $response = $this->deleteJson(route('products.destroy', $product->id));

        // Vérifier que la suppression a réussi
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Produit supprimé avec succès',
                 ]);

        // Vérifier que le produit n'existe plus dans la base de données
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
