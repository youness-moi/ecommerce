<?php
namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    public function getItems()
    {
        return Session::get('cart', []);
    }

    public function addItem($productId, $quantity)
    {
        $cart = $this->getItems();
        $cart[$productId] = $quantity;
        Session::put('cart', $cart);
    }

    public function updateItem($productId, $quantity)
    {
        $cart = $this->getItems();
        if (isset($cart[$productId])) {
            $cart[$productId] = $quantity;
            Session::put('cart', $cart);
        }
    }

    public function removeItem($productId)
    {
        $cart = $this->getItems();
        unset($cart[$productId]);
        Session::put('cart', $cart);
    }

    public function clear()
    {
        Session::forget('cart');
    }
}
