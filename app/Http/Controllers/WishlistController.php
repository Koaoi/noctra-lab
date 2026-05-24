<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()
            ->wishlists()
            ->with(['product.primaryImage', 'product.category'])
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        $user     = auth()->user();
        $existing = $user->wishlists()->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
        } else {
            $user->wishlists()->create(['product_id' => $product->id]);
            $wishlisted = true;
        }

        // AJAX response
        if (request()->expectsJson()) {
            return response()->json(['wishlisted' => $wishlisted]);
        }

        $msg = $wishlisted
            ? '"' . $product->name . '" ditambahkan ke wishlist.'
            : '"' . $product->name . '" dihapus dari wishlist.';

        return back()->with('success', $msg);
    }
}