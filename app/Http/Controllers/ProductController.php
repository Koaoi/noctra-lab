<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function landing()
    {
        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->where('status', '!=', 'coming_soon')
            ->latest()
            ->take(4)
            ->get();

        $comingSoon = Product::where('status', 'coming_soon')
            ->whereNotNull('drop_at')
            ->latest()
            ->first();

        $categories = Category::active()->withCount('products')->get();

        return view('home', compact('featuredProducts', 'comingSoon', 'categories'));
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage']);

        // Search
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products   = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::active()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with([
            'category',
            'images',
            'reviews.user',
        ])->where('slug', $slug)->firstOrFail();

        $related = Product::with(['primaryImage'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->available()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}