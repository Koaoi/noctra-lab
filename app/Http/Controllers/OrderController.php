<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with(['items.product', 'payment'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load([
            'items.product.primaryImage',
            'payment',
            'shippingAddress',
        ]);

        return view('orders.show', compact('order'));
    }
}