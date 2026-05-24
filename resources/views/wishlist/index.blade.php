@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')
<div class="container" style="padding-top:3rem; padding-bottom:5rem;">

    <div class="mb-4">
        <p class="noctra-label mb-1">Your</p>
        <h1 style="font-size:clamp(1.5rem,3vw,2.5rem); font-weight:900;
                   letter-spacing:-.03em; text-transform:uppercase; margin:0;">
            Wishlist
        </h1>
    </div>

    @if($wishlists->isEmpty())
    <div style="text-align:center; padding:6rem 0;">
        <p style="font-size:4rem; margin-bottom:1rem; opacity:.3;">♡</p>
        <p style="color:var(--noctra-gray); font-size:1.1rem; margin-bottom:2rem;">
            Wishlist kamu masih kosong.
        </p>
        <a href="{{ route('products.index') }}" class="btn-noctra"
           style="display:inline-block;">
            Explore Products
        </a>
    </div>
    @else

    <div class="row g-3">
        @foreach($wishlists as $wishlist)
        <div class="col-6 col-md-3">
            <div class="product-card" style="position:relative;">

                {{-- Remove from wishlist --}}
                <form method="POST"
                      action="{{ route('wishlist.toggle', $wishlist->product) }}"
                      style="position:absolute; top:12px; right:12px; z-index:10;">
                    @csrf
                    <button type="submit"
                            style="width:32px; height:32px; background:rgba(10,10,10,.7);
                                   border:1px solid var(--noctra-border); color:var(--noctra-white);
                                   cursor:pointer; font-size:1rem; display:flex;
                                   align-items:center; justify-content:center;"
                            title="Remove from wishlist">
                        ♥
                    </button>
                </form>

                <a href="{{ route('products.show', $wishlist->product->slug) }}"
                   style="text-decoration:none; display:block;">
                    <div class="card-img-wrapper">
                        <img src="{{ $wishlist->product->primary_image_url }}"
                             alt="{{ $wishlist->product->name }}"
                             loading="lazy">
                        @if($wishlist->product->is_limited)
                            <span class="badge-limited">Limited</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="product-category">{{ $wishlist->product->category->name }}</p>
                        <p class="product-name">{{ $wishlist->product->name }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="product-price">{{ $wishlist->product->formatted_price }}</span>
                            <span class="badge-status badge-{{ str_replace('_','-',$wishlist->product->status) }}">
                                {{ $wishlist->product->status_label }}
                            </span>
                        </div>
                    </div>
                </a>

                @if($wishlist->product->is_available)
                <div style="padding:0 1rem 1rem;">
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-noctra-dark w-100"
                                style="font-size:11px; padding:.5rem;">
                            Add to Cart
                        </button>
                    </form>
                </div>
                @endif

            </div>
        </div>
        @endforeach
    </div>

    @endif
</div>
@endsection