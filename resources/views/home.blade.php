@extends('layouts.app')

@section('title', 'NOCTRA LAB — Limited Fashion Drop')

@section('content')

{{-- HERO --}}
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <p class="hero-eyebrow">Korean Streetwear — Limited Drop</p>
            <h1 class="hero-title">
                WEAR<br>THE<br>DARK.
            </h1>
            <p class="hero-subtitle">
                Premium limited fashion. Korean streetwear aesthetic.
                Minimal. Monochrome. Exclusive drops.
            </p>

            @if($comingSoon && $comingSoon->drop_at)
            <div class="mb-4">
                <p class="noctra-label mb-2">Next Drop — {{ $comingSoon->name }}</p>
                <div class="countdown-wrap">
                    <div data-countdown="{{ $comingSoon->drop_at->toIso8601String() }}">
                        <span class="countdown-unit">--<small>d</small></span>
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('products.index') }}" class="btn-noctra">
                    Shop Now
                </a>
                <a href="{{ route('commission.index') }}" class="btn-noctra-outline">
                    Commission
                </a>
            </div>
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="noctra-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <p class="section-title">Featured</p>
                <h2 class="section-heading">New Arrivals</h2>
            </div>
            <a href="{{ route('products.index') }}"
               style="font-size: 12px; font-weight: 700; letter-spacing: .08em;
                      text-transform: uppercase; color: var(--noctra-gray);">
                View All →
            </a>
        </div>

        <div class="row g-3">
            @forelse($featuredProducts as $product)
            <div class="col-6 col-md-3">
                <a href="{{ route('products.show', $product->slug) }}"
                   style="text-decoration: none; display: block;">
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
                            @endif
                        </div>

                        <div class="card-body">
                            <p class="product-category">{{ $product->category->name }}</p>
                            <p class="product-name">{{ $product->name }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">{{ $product->formatted_price }}</span>
                                <span class="badge-status badge-{{ str_replace('_', '-', $product->status) }}">
                                    {{ $product->status_label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <p style="color: var(--noctra-gray); text-align: center; padding: 3rem 0;">
                    Produk segera hadir.
                </p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- COMMISSION BANNER --}}
<section style="padding: 5rem 0; background: var(--noctra-dark); border-top: 1px solid var(--noctra-border);">
    <div class="container text-center">
        <p class="section-title">Custom Order</p>
        <h2 class="section-heading mb-3">Commission Your Design</h2>
        <p style="color: var(--noctra-gray); font-size: 1rem; max-width: 480px; margin: 0 auto 2rem;">
            Punya ide desain sendiri? Kami terima commission fashion custom sesuai konsep kamu.
        </p>
        <a href="{{ route('commission.index') }}" class="btn-noctra">
            Request Commission
        </a>
    </div>
</section>

@endsection