@extends('layouts.app')

@section('title', $commission->title)

@section('content')
<div class="container" style="padding-top:3rem; padding-bottom:5rem;">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('commission.index') }}"
                   style="font-size:12px; color:var(--noctra-gray);
                          letter-spacing:.06em; text-transform:uppercase;">
                    ← Commission
                </a>
            </div>

            <div style="background:var(--noctra-card); border:1px solid var(--noctra-border); padding:2rem;">

                <div class="d-flex justify-content-between align-items-start mb-4">
                    <h1 style="font-size:1.25rem; font-weight:800; letter-spacing:-.01em; margin:0;">
                        {{ $commission->title }}
                    </h1>
                    <span class="badge-status badge-{{ str_replace(['_',' '],'-',$commission->status) }}">
                        {{ $commission->status_label }}
                    </span>
                </div>

                <div class="mb-3">
                    <p class="noctra-label mb-1">Description</p>
                    <p style="font-size:14px; color:var(--noctra-silver); line-height:1.8; margin:0;">
                        {{ $commission->description }}
                    </p>
                </div>

                @if($commission->size_preference || $commission->color_preference)
                <div class="row g-3 mb-3">
                    @if($commission->size_preference)
                    <div class="col-md-6">
                        <p class="noctra-label mb-1">Size Preference</p>
                        <p style="font-size:14px; color:var(--noctra-silver); margin:0;">
                            {{ $commission->size_preference }}
                        </p>
                    </div>
                    @endif
                    @if($commission->color_preference)
                    <div class="col-md-6">
                        <p class="noctra-label mb-1">Color Preference</p>
                        <p style="font-size:14px; color:var(--noctra-silver); margin:0;">
                            {{ $commission->color_preference }}
                        </p>
                    </div>
                    @endif
                </div>
                @endif

                @if($commission->budget)
                <div class="mb-3">
                    <p class="noctra-label mb-1">Budget</p>
                    <p style="font-size:14px; color:var(--noctra-silver); margin:0;">
                        Rp {{ number_format($commission->budget, 0, ',', '.') }}
                    </p>
                </div>
                @endif

                @if($commission->quoted_price)
                <div class="mb-3" style="padding:1rem; background:rgba(91,192,222,.08);
                                          border:1px solid rgba(91,192,222,.2);">
                    <p class="noctra-label mb-1" style="color:#5bc0de;">Quoted Price</p>
                    <p style="font-size:1.25rem; font-weight:800; color:var(--noctra-white); margin:0;">
                        Rp {{ number_format($commission->quoted_price, 0, ',', '.') }}
                    </p>
                </div>
                @endif

                @if($commission->admin_notes)
                <div class="mb-3" style="padding:1rem; background:var(--noctra-dark);
                                          border:1px solid var(--noctra-border);">
                    <p class="noctra-label mb-1">Admin Notes</p>
                    <p style="font-size:13px; color:var(--noctra-silver); margin:0; line-height:1.7;">
                        {{ $commission->admin_notes }}
                    </p>
                </div>
                @endif

                @if($commission->reference_image_url)
                <div class="mb-3">
                    <p class="noctra-label mb-2">Reference Image</p>
                    <img src="{{ $commission->reference_image_url }}"
                         alt="Reference"
                         style="max-height:300px; border:1px solid var(--noctra-border);">
                </div>
                @endif

                <hr style="border-color:var(--noctra-border); margin:1.5rem 0;">
                <p style="font-size:12px; color:var(--noctra-gray); margin:0;">
                    Submitted: {{ $commission->created_at->format('d M Y, H:i') }}
                </p>

            </div>
        </div>
    </div>
</div>
@endsection