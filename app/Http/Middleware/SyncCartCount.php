<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Hapus "extends Middleware" dari deklarasi kelas
class SyncCartCount
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $cart = auth()->user()->cart()->withCount([
                'items as item_count' => fn($q) => $q->selectRaw('sum(quantity)')
            ])->first();

            session(['cart_count' => $cart?->item_count ?? 0]);
        }

        return $next($request);
    }
}