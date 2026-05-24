<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'comment'    => ['nullable', 'string', 'max:1000'],
        ]);

        $user    = auth()->user();
        $product = Product::findOrFail($request->product_id);

        // Cek duplikat review
        $existing = Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Kamu sudah menulis review untuk produk ini.');
        }

        Review::create([
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', 'Review berhasil dikirim. Terima kasih!');
    }
}