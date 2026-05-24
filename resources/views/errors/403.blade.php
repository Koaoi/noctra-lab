@extends('layouts.app')

@section('title', '403 — Forbidden')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="text-center">
        <p class="noctra-label mb-3">Error 403</p>
        <h1 style="font-size: clamp(4rem, 12vw, 8rem); font-weight: 900;
                   letter-spacing: -.04em; color: var(--noctra-white); line-height: 1;">
            FORBIDDEN
        </h1>
        <p style="color: var(--noctra-gray); font-size: 1rem; margin: 1.5rem 0 2.5rem;">
            Kamu tidak punya akses ke halaman ini.
        </p>
        <a href="{{ route('home') }}" class="btn-noctra">
            Kembali ke Home
        </a>
    </div>
</div>
@endsection