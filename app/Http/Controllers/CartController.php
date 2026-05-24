<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart()->load([
            'items.product.primaryImage',
            'items.product.category',
        ]);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1', 'max:10'],
            'size'       => ['nullable', 'string', 'max:10'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < 1 && $product->status === 'available') {
            return back()->with('error', 'Produk sudah habis.');
        }

        $cart = $this->getOrCreateCart();

        $existingItem = $cart->items()
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->first();

        if ($existingItem) {
            $newQty = $existingItem->quantity + $request->quantity;
            if ($newQty > $product->stock && $product->status === 'available') {
                $newQty = $product->stock;
            }
            $existingItem->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'size'       => $request->size,
                'quantity'   => $request->quantity,
            ]);
        }

        // Update cart count di session
        $this->syncCartCount($cart);

        return back()->with('success', '"' . $product->name . '" ditambahkan ke cart.');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cart = $this->getOrCreateCart();

        $item = $cart->items()->findOrFail($id);
        $item->update(['quantity' => $request->quantity]);

        $this->syncCartCount($cart);

        return back()->with('success', 'Cart diperbarui.');
    }

    public function remove(int $id)
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->findOrFail($id)->delete();

        $this->syncCartCount($cart);

        return back()->with('success', 'Item dihapus dari cart.');
    }

    private function syncCartCount(Cart $cart): void
    {
        $count = $cart->items()->sum('quantity');
        session(['cart_count' => $count]);
    }
}