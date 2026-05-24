@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit($product->description, 160))

@section('content')
<div class="container" style="padding-top:3rem; padding-bottom:5rem;">

    {{-- Breadcrumb --}}
    <nav style="margin-bottom:2rem; font-size:12px; color:var(--noctra-gray);
                letter-spacing:.06em; text-transform:uppercase;">
        <a href="{{ route('home') }}" style="color:var(--noctra-gray);">Home</a>
        <span style="margin:0 .5rem;">›</span>
        <a href="{{ route('products.index') }}" style="color:var(--noctra-gray);">Products</a>
        <span style="margin:0 .5rem;">›</span>
        <span style="color:var(--noctra-white);">{{ Str::limit($product->name, 30) }}</span>
    </nav>

    <div class="row g-5">

        {{-- ── IMAGE GALLERY ── --}}
        <div class="col-lg-6">
            {{-- Main Image --}}
            <div id="mainImageWrap"
                 style="aspect-ratio:3/4; background:var(--noctra-card);
                        border:1px solid var(--noctra-border); overflow:hidden; margin-bottom:.75rem;">
                <img id="mainImage"
                     src="{{ $product->primary_image_url }}"
                     alt="{{ $product->name }}"
                     style="width:100%; height:100%; object-fit:cover; transition:opacity .25s ease;">
            </div>

            {{-- Thumbnail Strip --}}
            @if($product->images->count() > 1)
            <div style="display:flex; gap:.5rem; overflow-x:auto;">
                @foreach($product->images as $img)
                <div class="thumb-img"
                     data-src="{{ asset('storage/' . $img->image_path) }}"
                     style="width:72px; height:72px; flex-shrink:0; cursor:pointer;
                            border:1px solid {{ $img->is_primary ? 'var(--noctra-white)' : 'var(--noctra-border)' }};
                            overflow:hidden; transition:border-color .2s;">
                    <img src="{{ asset('storage/' . $img->image_path) }}"
                         alt="view"
                         style="width:100%; height:100%; object-fit:cover;">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ── PRODUCT INFO ── --}}
        <div class="col-lg-6">

            {{-- Category + Badges --}}
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="noctra-label">{{ $product->category->name }}</span>
                @if($product->is_limited)
                    <span class="badge-status" style="background:#1a1a1a; color:var(--noctra-white);
                                                       border:1px solid var(--noctra-white);">
                        ★ Limited
                    </span>
                @endif
                <span class="badge-status badge-{{ str_replace('_','-',$product->status) }}">
                    {{ $product->status_label }}
                </span>
            </div>

            {{-- Name --}}
            <h1 style="font-size:clamp(1.5rem,3vw,2.25rem); font-weight:900;
                       letter-spacing:-.02em; line-height:1.1; margin-bottom:1rem;">
                {{ $product->name }}
            </h1>

            {{-- Rating --}}
            @if($product->reviews->count() > 0)
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="color:var(--noctra-gold); letter-spacing:.1em;">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= round($product->average_rating) ? '★' : '☆' }}
                    @endfor
                </div>
                <span style="font-size:13px; color:var(--noctra-gray);">
                    {{ number_format($product->average_rating, 1) }}
                    ({{ $product->reviews->count() }} reviews)
                </span>
            </div>
            @endif

            {{-- Price --}}
            <p style="font-size:2rem; font-weight:900; letter-spacing:-.02em; margin-bottom:1.5rem;">
                {{ $product->formatted_price }}
            </p>

            {{-- Stock indicator --}}
            @if($product->status === 'available')
                @if($product->stock <= 5 && $product->stock > 0)
                <div style="margin-bottom:1.25rem; padding:.6rem .875rem;
                            background:rgba(212,168,67,.1); border:1px solid rgba(212,168,67,.3);">
                    <span style="font-size:12px; color:var(--noctra-gold); font-weight:700;
                                 letter-spacing:.06em;">
                        ⚡ Only {{ $product->stock }} items left!
                    </span>
                </div>
                @endif
            @endif

            {{-- Countdown (jika coming soon) --}}
            @if($product->status === 'coming_soon' && $product->drop_at)
            <div class="countdown-wrap mb-4">
                <p class="noctra-label mb-2" style="width:100%;">Drop in</p>
                <div data-countdown="{{ $product->drop_at->toIso8601String() }}">
                    <span class="countdown-unit">--<small>d</small></span>
                </div>
            </div>
            @endif

            {{-- Add to Cart Form --}}
            @if($product->is_available)
            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                {{-- Size Selector --}}
                @if($product->sizes && count($product->sizes) > 0)
                <div class="mb-4">
                    <label class="form-label-noctra">Select Size</label>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        @foreach($product->sizes as $size)
                        <label style="cursor:pointer;">
                            <input type="radio" name="size" value="{{ $size }}"
                                   style="display:none;"
                                   class="size-radio"
                                   {{ $loop->first ? 'checked' : '' }}>
                            <span class="size-btn"
                                  style="display:inline-block; padding:.45rem .875rem;
                                         border:1px solid var(--noctra-border);
                                         font-size:12px; font-weight:700;
                                         letter-spacing:.06em; text-transform:uppercase;
                                         color:var(--noctra-gray); cursor:pointer;
                                         transition:all .2s;">
                                {{ $size }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Quantity --}}
                <div class="mb-4">
                    <label class="form-label-noctra">Quantity</label>
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div style="display:flex; align-items:center;
                                    border:1px solid var(--noctra-border); background:var(--noctra-card);">
                            <button type="button" id="qtyMinus"
                                    style="width:36px; height:36px; background:none; border:none;
                                           color:var(--noctra-white); font-size:1.1rem; cursor:pointer;">
                                −
                            </button>
                            <input type="number" name="quantity" id="qtyInput"
                                   value="1" min="1" max="{{ $product->stock }}"
                                   style="width:48px; height:36px; text-align:center;
                                          background:none; border:none; border-left:1px solid var(--noctra-border);
                                          border-right:1px solid var(--noctra-border);
                                          color:var(--noctra-white); font-size:14px; font-weight:700;">
                            <button type="button" id="qtyPlus"
                                    style="width:36px; height:36px; background:none; border:none;
                                           color:var(--noctra-white); font-size:1.1rem; cursor:pointer;">
                                +
                            </button>
                        </div>
                        <span style="font-size:12px; color:var(--noctra-gray);">
                            {{ $product->stock }} available
                        </span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                @auth
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-noctra" style="flex:1;">
                        Add to Cart
                    </button>
                    <button type="button"
                            onclick="toggleWishlist({{ $product->id }}, this)"
                            class="btn-noctra-dark"
                            style="width:48px; height:48px; padding:0; display:flex;
                                   align-items:center; justify-content:center; font-size:1.2rem;"
                            title="Add to Wishlist">
                        @auth
                            {{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? '♥' : '♡' }}
                        @endauth
                    </button>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn-noctra w-100"
                   style="display:block; text-align:center;">
                    Login to Purchase
                </a>
                @endauth
            </form>

            @elseif($product->status === 'preorder')
            <div style="padding:1rem; border:1px solid var(--noctra-border);
                        background:rgba(91,192,222,.08); margin-bottom:1rem;">
                <p style="font-size:13px; color:#5bc0de; margin:0; font-weight:600;">
                    Produk ini dalam status <strong>Preorder</strong>.
                    Pembayaran dilakukan sekarang, produk dikirim sesuai jadwal.
                </p>
            </div>
            @auth
            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-noctra w-100"
                        style="display:block; text-align:center;">
                    Preorder Now
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn-noctra w-100"
               style="display:block; text-align:center;">
                Login to Preorder
            </a>
            @endauth

            @else
            <button disabled class="btn-noctra w-100"
                    style="display:block; text-align:center; opacity:.4; cursor:not-allowed;">
                {{ $product->status_label }}
            </button>
            @endif

            {{-- Material --}}
            @if($product->material)
            <div style="margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid var(--noctra-border);">
                <p class="noctra-label mb-1">Material</p>
                <p style="font-size:13px; color:var(--noctra-silver);">{{ $product->material }}</p>
            </div>
            @endif

            {{-- Description --}}
            <div style="margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid var(--noctra-border);">
                <p class="noctra-label mb-2">Description</p>
                <p style="font-size:14px; color:var(--noctra-silver); line-height:1.8;">
                    {{ $product->description }}
                </p>
            </div>

        </div>
    </div>

    {{-- ── REVIEWS ── --}}
    <div style="margin-top:5rem; padding-top:3rem; border-top:1px solid var(--noctra-border);">
        <h2 class="section-heading mb-4">Reviews</h2>

        @if($product->reviews->isEmpty())
        <p style="color:var(--noctra-gray);">Belum ada review untuk produk ini.</p>
        @else
        <div class="row g-3">
            @foreach($product->reviews as $review)
            <div class="col-md-6">
                <div style="background:var(--noctra-card); border:1px solid var(--noctra-border); padding:1.25rem;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <p style="font-size:14px; font-weight:700; color:var(--noctra-white); margin:0;">
                                {{ $review->user->name }}
                            </p>
                            <p style="font-size:11px; color:var(--noctra-gray); margin:0;">
                                {{ $review->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <div style="color:var(--noctra-gold); letter-spacing:.08em;">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                    @if($review->comment)
                    <p style="font-size:14px; color:var(--noctra-silver); margin:0; line-height:1.7;">
                        {{ $review->comment }}
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Review Form --}}
        @auth
        <div style="margin-top:2rem; padding:1.5rem; background:var(--noctra-card);
                    border:1px solid var(--noctra-border);">
            <h4 style="font-size:14px; font-weight:800; letter-spacing:.06em;
                       text-transform:uppercase; margin-bottom:1.25rem;">
                Write a Review
            </h4>
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="mb-3">
                    <label class="form-label-noctra">Rating</label>
                    <div class="d-flex gap-2 mt-1">
                        @for($i = 1; $i <= 5; $i++)
                        <label style="cursor:pointer; font-size:1.5rem; color:var(--noctra-gray);"
                               class="star-label">
                            <input type="radio" name="rating" value="{{ $i }}"
                                   style="display:none;" required>
                            ★
                        </label>
                        @endfor
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label-noctra">Comment</label>
                    <textarea name="comment" rows="3"
                              class="form-control form-control-noctra"
                              placeholder="Share your experience with this product..."></textarea>
                </div>

                <button type="submit" class="btn-noctra-dark">Submit Review</button>
            </form>
        </div>
        @endauth
    </div>

    {{-- ── RELATED PRODUCTS ── --}}
    @if($related->isNotEmpty())
    <div style="margin-top:4rem; padding-top:3rem; border-top:1px solid var(--noctra-border);">
        <h2 class="section-heading mb-4">You May Also Like</h2>
        <div class="row g-3">
            @foreach($related as $rel)
            <div class="col-6 col-md-3">
                <a href="{{ route('products.show', $rel->slug) }}" style="text-decoration:none; display:block;">
                    <div class="product-card">
                        <div class="card-img-wrapper">
                            <img src="{{ $rel->primary_image_url }}" alt="{{ $rel->name }}" loading="lazy">
                            @if($rel->is_limited)
                                <span class="badge-limited">Limited</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <p class="product-name">{{ $rel->name }}</p>
                            <p class="product-price">{{ $rel->formatted_price }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
// Image gallery thumbnail switch
document.querySelectorAll('.thumb-img').forEach(function(thumb) {
    thumb.addEventListener('click', function() {
        const mainImg = document.getElementById('mainImage');
        mainImg.style.opacity = '0';
        setTimeout(function() {
            mainImg.src = thumb.dataset.src;
            mainImg.style.opacity = '1';
        }, 150);
        document.querySelectorAll('.thumb-img').forEach(function(t) {
            t.style.borderColor = 'var(--noctra-border)';
        });
        thumb.style.borderColor = 'var(--noctra-white)';
    });
});

// Size selector highlight
document.querySelectorAll('.size-radio').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.size-btn').forEach(function(btn) {
            btn.style.borderColor = 'var(--noctra-border)';
            btn.style.color = 'var(--noctra-gray)';
        });
        this.nextElementSibling.style.borderColor = 'var(--noctra-white)';
        this.nextElementSibling.style.color = 'var(--noctra-white)';
    });
    // Highlight default selected
    if (radio.checked) {
        radio.nextElementSibling.style.borderColor = 'var(--noctra-white)';
        radio.nextElementSibling.style.color = 'var(--noctra-white)';
    }
});

// Quantity buttons
const qtyInput = document.getElementById('qtyInput');
const maxQty   = parseInt(qtyInput?.max || 99);

document.getElementById('qtyMinus')?.addEventListener('click', function() {
    let val = parseInt(qtyInput.value);
    if (val > 1) qtyInput.value = val - 1;
});
document.getElementById('qtyPlus')?.addEventListener('click', function() {
    let val = parseInt(qtyInput.value);
    if (val < maxQty) qtyInput.value = val + 1;
});

// Star rating highlight
document.querySelectorAll('.star-label').forEach(function(label, i, all) {
    label.addEventListener('mouseenter', function() {
        all.forEach(function(l, j) {
            l.style.color = j <= i ? 'var(--noctra-gold)' : 'var(--noctra-gray)';
        });
    });
    label.addEventListener('mouseleave', function() {
        const checked = document.querySelector('.star-label input:checked');
        const checkedIndex = checked ? parseInt(checked.value) - 1 : -1;
        all.forEach(function(l, j) {
            l.style.color = j <= checkedIndex ? 'var(--noctra-gold)' : 'var(--noctra-gray)';
        });
    });
    label.querySelector('input').addEventListener('change', function() {
        const idx = parseInt(this.value) - 1;
        all.forEach(function(l, j) {
            l.style.color = j <= idx ? 'var(--noctra-gold)' : 'var(--noctra-gray)';
        });
    });
});

// Wishlist toggle
function toggleWishlist(productId, btn) {
    fetch('{{ route("wishlist.toggle", ":id") }}'.replace(':id', productId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        btn.textContent = data.wishlisted ? '♥' : '♡';
    })
    .catch(() => {
        window.location.href = '{{ route("login") }}';
    });
}
</script>
@endpush