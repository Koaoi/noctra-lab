@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container" style="padding-top:3rem; padding-bottom:5rem;">

    <div class="mb-4">
        <p class="noctra-label mb-1">Your</p>
        <h1 style="font-size:clamp(1.5rem,3vw,2.5rem); font-weight:900;
                   letter-spacing:-.03em; text-transform:uppercase; margin:0;">
            Order History
        </h1>
    </div>

    @if($orders->isEmpty())
    <div style="text-align:center; padding:5rem 0;">
        <p style="font-size:3rem; margin-bottom:1rem; opacity:.3;">📦</p>
        <p style="color:var(--noctra-gray); font-size:1.1rem; margin-bottom:2rem;">
            Belum ada pesanan.
        </p>
        <a href="{{ route('products.index') }}" class="btn-noctra"
           style="display:inline-block;">
            Shop Now
        </a>
    </div>
    @else

    <div style="display:flex; flex-direction:column; gap:.75rem;">
        @foreach($orders as $order)
        <div style="background:var(--noctra-card); border:1px solid var(--noctra-border); padding:1.5rem;">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <p style="font-size:12px; font-weight:700; letter-spacing:.08em;
                               text-transform:uppercase; color:var(--noctra-gray); margin:0 0 .25rem;">
                        Order Number
                    </p>
                    <p style="font-size:15px; font-weight:800; color:var(--noctra-white); margin:0;">
                        {{ $order->order_number }}
                    </p>
                </div>
                <div style="text-align:right;">
                    <span class="badge-status badge-{{ str_replace(['_',' '],'-',$order->status) }}">
                        {{ $order->status_label }}
                    </span>
                    <p style="font-size:12px; color:var(--noctra-gray); margin:.25rem 0 0;">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>

            {{-- Items preview --}}
            <div class="d-flex gap-2 mb-3" style="overflow:hidden;">
                @foreach($order->items->take(4) as $item)
                <div style="width:56px; height:68px; background:var(--noctra-muted);
                            overflow:hidden; flex-shrink:0;">
                    @if($item->product && $item->product->primaryImage)
                    <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                         alt="{{ $item->product_name }}"
                         style="width:100%; height:100%; object-fit:cover;">
                    @endif
                </div>
                @endforeach
                @if($order->items->count() > 4)
                <div style="width:56px; height:68px; background:var(--noctra-muted);
                            display:flex; align-items:center; justify-content:center;
                            font-size:12px; color:var(--noctra-gray); font-weight:700;">
                    +{{ $order->items->count() - 4 }}
                </div>
                @endif
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span style="font-size:13px; color:var(--noctra-gray);">
                        {{ $order->items->count() }} item(s)
                    </span>
                    <span style="font-size:16px; font-weight:800; color:var(--noctra-white);
                                 margin-left:1rem;">
                        {{ $order->formatted_total }}
                    </span>
                </div>
                <a href="{{ route('orders.show', $order) }}"
                   class="btn-noctra-dark" style="font-size:11px; padding:.5rem 1rem;">
                    View Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>

    @endif
</div>
@endsection