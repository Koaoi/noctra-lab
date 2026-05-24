@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container" style="padding-top:3rem; padding-bottom:5rem;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <p class="noctra-label mb-1">Your</p>
            <h1 style="font-size:clamp(1.5rem,3vw,2.5rem); font-weight:900;
                       letter-spacing:-.03em; text-transform:uppercase; margin:0;">
                Shopping Cart
            </h1>
        </div>
        @if($cart->items->isNotEmpty())
        <span style="font-size:13px; color:var(--noctra-gray);">
            {{ $cart->item_count }} item{{ $cart->item_count !== 1 ? 's' : '' }}
        </span>
        @endif
    </div>

    @if($cart->items->isEmpty())
    {{-- Empty State --}}
    <div style="text-align:center; padding:6rem 0;">
        <p style="font-size:4rem; margin-bottom:1rem; opacity:.3;">∅</p>
        <p style="color:var(--noctra-gray); font-size:1.1rem; margin-bottom:2rem;">
            Your cart is empty.
        </p>
        <a href="{{ route('products.index') }}" class="btn-noctra"
           style="display:inline-block;">
            Start Shopping
        </a>
    </div>
    @else

    <div class="row g-4">

        {{-- Cart Items --}}
        <div class="col-lg-8">
            @foreach($cart->items as $item)
            <div style="display:flex; gap:1rem; padding:1.25rem;
                        background:var(--noctra-card); border:1px solid var(--noctra-border);
                        margin-bottom:.75rem; align-items:flex-start;">

                {{-- Product Image --}}
                <a href="{{ route('products.show', $item->product->slug) }}"
                   style="flex-shrink:0; width:90px; height:110px; overflow:hidden;
                          background:var(--noctra-muted); display:block;">
                    <img src="{{ $item->product->primary_image_url }}"
                         alt="{{ $item->product->name }}"
                         style="width:100%; height:100%; object-fit:cover;">
                </a>

                {{-- Info --}}
                <div style="flex:1; min-width:0;">
                    <p style="font-size:11px; letter-spacing:.08em; text-transform:uppercase;
                               color:var(--noctra-gray); margin-bottom:.25rem;">
                        {{ $item->product->category->name }}
                        @if($item->size)
                            · Size: <strong style="color:var(--noctra-silver);">{{ $item->size }}</strong>
                        @endif
                    </p>
                    <p style="font-size:15px; font-weight:700; color:var(--noctra-white);
                               margin-bottom:.75rem; line-height:1.3;">
                        <a href="{{ route('products.show', $item->product->slug) }}"
                           style="color:inherit;">
                            {{ $item->product->name }}
                        </a>
                    </p>
                    <p style="font-size:14px; font-weight:700; color:var(--noctra-white); margin-bottom:.75rem;">
                        {{ 'Rp ' . number_format($item->product->price, 0, ',', '.') }}
                    </p>

                    {{-- Quantity + Remove --}}
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <form method="POST" action="{{ route('cart.update', $item->id) }}"
                              style="display:flex; align-items:center;">
                            @csrf
                            @method('PATCH')
                            <div style="display:flex; align-items:center;
                                        border:1px solid var(--noctra-border);">
                                <button type="button" class="qty-minus"
                                        style="width:32px; height:32px; background:none; border:none;
                                               color:var(--noctra-white); cursor:pointer;">−</button>
                                <input type="number" name="quantity"
                                       value="{{ $item->quantity }}" min="1" max="10"
                                       class="qty-input"
                                       style="width:40px; height:32px; text-align:center;
                                              background:none; border:none;
                                              border-left:1px solid var(--noctra-border);
                                              border-right:1px solid var(--noctra-border);
                                              color:var(--noctra-white); font-size:13px; font-weight:700;">
                                <button type="button" class="qty-plus"
                                        style="width:32px; height:32px; background:none; border:none;
                                               color:var(--noctra-white); cursor:pointer;">+</button>
                            </div>
                            <button type="submit"
                                    style="margin-left:.5rem; background:none; border:none;
                                           font-size:11px; font-weight:700; letter-spacing:.06em;
                                           text-transform:uppercase; color:var(--noctra-gray);
                                           cursor:pointer; padding:.25rem .5rem;
                                           border-bottom:1px solid var(--noctra-border);">
                                Update
                            </button>
                        </form>

                        <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background:none; border:none; font-size:11px;
                                           font-weight:700; letter-spacing:.06em; text-transform:uppercase;
                                           color:var(--noctra-red); cursor:pointer;">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Subtotal --}}
                <div style="flex-shrink:0; text-align:right;">
                    <p style="font-size:15px; font-weight:800; color:var(--noctra-white); margin:0;">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </p>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div style="background:var(--noctra-card); border:1px solid var(--noctra-border);
                        padding:1.5rem; position:sticky; top:5rem;">
                <h4 style="font-size:13px; font-weight:800; letter-spacing:.1em;
                           text-transform:uppercase; margin-bottom:1.5rem;">
                    Order Summary
                </h4>

                <div style="display:flex; justify-content:space-between; margin-bottom:.875rem;">
                    <span style="font-size:13px; color:var(--noctra-gray);">
                        Subtotal ({{ $cart->item_count }} items)
                    </span>
                    <span style="font-size:13px; color:var(--noctra-white); font-weight:700;">
                        Rp {{ number_format($cart->total, 0, ',', '.') }}
                    </span>
                </div>

                <div style="display:flex; justify-content:space-between; margin-bottom:.875rem;">
                    <span style="font-size:13px; color:var(--noctra-gray);">Shipping</span>
                    <span style="font-size:13px; color:var(--noctra-gray);">
                        Calculated at checkout
                    </span>
                </div>

                <hr style="border-color:var(--noctra-border); margin:1.25rem 0;">

                <div style="display:flex; justify-content:space-between; margin-bottom:1.5rem;">
                    <span style="font-size:14px; font-weight:700; color:var(--noctra-white);">
                        Estimated Total
                    </span>
                    <span style="font-size:16px; font-weight:900; color:var(--noctra-white);">
                        Rp {{ number_format($cart->total, 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-noctra"
                   style="display:block; text-align:center;">
                    Proceed to Checkout
                </a>

                <a href="{{ route('products.index') }}"
                   style="display:block; text-align:center; margin-top:1rem;
                          font-size:12px; color:var(--noctra-gray); letter-spacing:.06em;
                          text-transform:uppercase;">
                    ← Continue Shopping
                </a>
            </div>
        </div>

    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.qty-minus').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const input = this.parentElement.querySelector('.qty-input');
        if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    });
});
document.querySelectorAll('.qty-plus').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const input = this.parentElement.querySelector('.qty-input');
        const max   = parseInt(input.max || 10);
        if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
    });
});
</script>
@endpush