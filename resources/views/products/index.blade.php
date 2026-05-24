@extends('layouts.app')

@section('title', 'All Products')

@section('content')

{{-- PAGE HEADER --}}
<div style="padding: 3rem 0 2rem; border-bottom: 1px solid var(--noctra-border); background: var(--noctra-dark);">
    <div class="container">
        <p class="noctra-label mb-2">NOCTRA LAB</p>
        <h1 style="font-size: clamp(1.75rem, 4vw, 3rem); font-weight: 900;
                   letter-spacing: -.03em; text-transform: uppercase; margin: 0;">
            All Products
        </h1>
    </div>
</div>

<div class="container" style="padding-top: 2.5rem; padding-bottom: 4rem;">
    <div class="row g-4">

        {{-- ── SIDEBAR FILTER ── --}}
        <div class="col-lg-3">
            <form method="GET" action="{{ route('products.index') }}" id="filterForm">

                {{-- Search --}}
                <div class="mb-4">
                    <label class="form-label-noctra">Search</label>
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           class="form-control form-control-noctra"
                           placeholder="Search products...">
                </div>

                <hr class="divider-noctra">

                {{-- Category --}}
                <div class="mb-4">
                    <label class="form-label-noctra">Category</label>
                    <div class="d-flex flex-column gap-2 mt-2">
                        <label class="d-flex align-items-center gap-2"
                               style="cursor:pointer; font-size:13px; color:var(--noctra-silver);">
                            <input type="radio" name="category" value=""
                                   {{ !request('category') ? 'checked' : '' }}
                                   style="accent-color:var(--noctra-white);"
                                   onchange="document.getElementById('filterForm').submit()">
                            All Categories
                        </label>
                        @foreach($categories as $cat)
                        <label class="d-flex align-items-center gap-2"
                               style="cursor:pointer; font-size:13px; color:var(--noctra-silver);">
                            <input type="radio" name="category" value="{{ $cat->slug }}"
                                   {{ request('category') === $cat->slug ? 'checked' : '' }}
                                   style="accent-color:var(--noctra-white);"
                                   onchange="document.getElementById('filterForm').submit()">
                            {{ $cat->name }}
                            <span style="color:var(--noctra-muted); font-size:11px;">
                                ({{ $cat->products_count }})
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <hr class="divider-noctra">

                {{-- Status --}}
                <div class="mb-4">
                    <label class="form-label-noctra">Availability</label>
                    <div class="d-flex flex-column gap-2 mt-2">
                        @foreach(['' => 'All', 'available' => 'Available', 'preorder' => 'Preorder', 'coming_soon' => 'Coming Soon'] as $val => $label)
                        <label class="d-flex align-items-center gap-2"
                               style="cursor:pointer; font-size:13px; color:var(--noctra-silver);">
                            <input type="radio" name="status" value="{{ $val }}"
                                   {{ request('status', '') === $val ? 'checked' : '' }}
                                   style="accent-color:var(--noctra-white);"
                                   onchange="document.getElementById('filterForm').submit()">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <hr class="divider-noctra">

                {{-- Price Range --}}
                <div class="mb-4">
                    <label class="form-label-noctra">Price Range</label>
                    <div class="d-flex gap-2 mt-2">
                        <input type="number" name="min_price"
                               value="{{ request('min_price') }}"
                               class="form-control form-control-noctra"
                               placeholder="Min" style="font-size:13px; padding:.5rem .75rem;">
                        <input type="number" name="max_price"
                               value="{{ request('max_price') }}"
                               class="form-control form-control-noctra"
                               placeholder="Max" style="font-size:13px; padding:.5rem .75rem;">
                    </div>
                    <button type="submit" class="btn-noctra-dark w-100 mt-2"
                            style="font-size:11px; padding:.5rem;">
                        Apply Price
                    </button>
                </div>

                @if(request()->hasAny(['q','category','status','min_price','max_price']))
                <a href="{{ route('products.index') }}"
                   style="display:block; text-align:center; font-size:11px; font-weight:700;
                          letter-spacing:.08em; text-transform:uppercase; color:var(--noctra-gray);
                          padding:.5rem; border:1px solid var(--noctra-border); margin-top:.5rem;">
                    Clear Filters
                </a>
                @endif

            </form>
        </div>

        {{-- ── PRODUCT GRID ── --}}
        <div class="col-lg-9">

            {{-- Result count --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p style="font-size:13px; color:var(--noctra-gray); margin:0;">
                    {{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }} found
                    @if(request('q'))
                        for "<span style="color:var(--noctra-white);">{{ request('q') }}</span>"
                    @endif
                </p>
                <span style="font-size:11px; letter-spacing:.06em; text-transform:uppercase; color:var(--noctra-muted);">
                    Page {{ $products->currentPage() }} / {{ $products->lastPage() }}
                </span>
            </div>

            @if($products->isEmpty())
            <div style="text-align:center; padding:5rem 0;">
                <p style="font-size:3rem; margin-bottom:1rem;">∅</p>
                <p style="color:var(--noctra-gray); font-size:1rem;">No products found.</p>
                <a href="{{ route('products.index') }}" class="btn-noctra-outline mt-3"
                   style="display:inline-block; padding:.6rem 1.5rem;">
                    Clear Filters
                </a>
            </div>
            @else

            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-6 col-md-4">
                    <a href="{{ route('products.show', $product->slug) }}"
                       style="text-decoration:none; display:block;">
                        <div class="product-card">
                            <div class="card-img-wrapper">
                                <img src="{{ $product->primary_image_url }}"
                                     alt="{{ $product->name }}"
                                     loading="lazy">

                                @if($product->is_limited)
                                    <span class="badge-limited">Limited</span>
                                @endif

                                @if($product->status === 'sold_out')
                                <div class="badge-soldout">
                                    <span>Sold Out</span>
                                </div>
                                @elseif($product->status === 'coming_soon')
                                <div class="badge-soldout">
                                    <span>Coming Soon</span>
                                </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <p class="product-category">{{ $product->category->name }}</p>
                                <p class="product-name">{{ $product->name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="product-price">{{ $product->formatted_price }}</span>
                                    @if($product->stock > 0 && $product->stock <= 5)
                                        <span style="font-size:10px; color:var(--noctra-gold);
                                                     font-weight:700; letter-spacing:.06em;">
                                            Only {{ $product->stock }} left
                                        </span>
                                    @else
                                        <span class="badge-status badge-{{ str_replace('_','-',$product->status) }}">
                                            {{ $product->status_label }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
            @endif

            @endif
        </div>
    </div>
</div>
@endsection