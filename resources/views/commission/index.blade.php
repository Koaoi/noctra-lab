@extends('layouts.app')

@section('title', 'Commission')

@section('content')

{{-- Hero --}}
<div style="padding:4rem 0; background:var(--noctra-dark); border-bottom:1px solid var(--noctra-border);">
    <div class="container text-center">
        <p class="noctra-label mb-3">Custom Design</p>
        <h1 style="font-size:clamp(2rem,5vw,4rem); font-weight:900;
                   letter-spacing:-.03em; text-transform:uppercase; margin-bottom:1rem;">
            Commission
        </h1>
        <p style="color:var(--noctra-gray); font-size:1rem; max-width:520px;
                  margin:0 auto 2.5rem; line-height:1.8;">
            Wujudkan konsep fashion kamu bersama NOCTRA LAB.
            Upload referensi desain, jelaskan visimu, dan kami akan membuat karya eksklusif untukmu.
        </p>
        @auth
        <a href="{{ route('commission.create') }}" class="btn-noctra"
           style="display:inline-block;">
            Request Commission
        </a>
        @else
        <a href="{{ route('login') }}" class="btn-noctra"
           style="display:inline-block;">
            Login to Request
        </a>
        @endauth
    </div>
</div>

{{-- How it Works --}}
<section class="noctra-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-title">Process</p>
            <h2 class="section-heading">How It Works</h2>
        </div>
        <div class="row g-4 text-center">
            @foreach([
                ['01', 'Submit Request', 'Isi form commission dengan detail desain dan referensi visual kamu.'],
                ['02', 'Review & Quote', 'Tim kami akan review request dan memberikan estimasi harga dalam 1-2 hari kerja.'],
                ['03', 'Production', 'Setelah deal, kami mulai produksi sesuai spesifikasi yang disepakati.'],
                ['04', 'Delivery', 'Produk custom dikirim ke alamat kamu dengan aman.'],
            ] as [$num, $title, $desc])
            <div class="col-md-3">
                <div style="padding:2rem 1.5rem; border:1px solid var(--noctra-border); height:100%;">
                    <p style="font-size:2.5rem; font-weight:900; color:var(--noctra-border);
                               letter-spacing:-.04em; margin-bottom:.75rem; line-height:1;">
                        {{ $num }}
                    </p>
                    <h4 style="font-size:14px; font-weight:800; letter-spacing:.06em;
                               text-transform:uppercase; margin-bottom:.75rem;">
                        {{ $title }}
                    </h4>
                    <p style="font-size:13px; color:var(--noctra-gray); margin:0; line-height:1.7;">
                        {{ $desc }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- My Commissions --}}
@auth
@if(auth()->user()->commissions()->exists())
<section style="padding-bottom:5rem;">
    <div class="container">
        <h2 class="section-heading mb-4">Your Commissions</h2>
        <div style="display:flex; flex-direction:column; gap:.75rem;">
            @foreach(auth()->user()->commissions()->latest()->get() as $commission)
            <a href="{{ route('commission.show', $commission) }}"
               style="text-decoration:none; display:flex; align-items:center; justify-content:space-between;
                      padding:1.25rem; background:var(--noctra-card); border:1px solid var(--noctra-border);
                      transition:border-color .2s;"
               class="commission-row">
                <div>
                    <p style="font-size:14px; font-weight:700; color:var(--noctra-white); margin:0 0 .25rem;">
                        {{ $commission->title }}
                    </p>
                    <p style="font-size:12px; color:var(--noctra-gray); margin:0;">
                        {{ $commission->created_at->format('d M Y') }}
                    </p>
                </div>
                <span class="badge-status badge-{{ str_replace(['_',' '],'-',$commission->status) }}">
                    {{ $commission->status_label }}
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endauth

@endsection