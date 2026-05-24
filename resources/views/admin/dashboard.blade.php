@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="noctra-label mb-1">Admin Panel</p>
        <h2 style="font-size: 1.5rem; font-weight: 800; margin: 0;">Dashboard</h2>
    </div>
    <p style="font-size: 13px; color: var(--noctra-gray);">
        {{ now()->format('l, d F Y') }}
    </p>
</div>

<p style="color: var(--noctra-gray);">
    Dashboard sedang dibangun. Lanjut ke Phase 7.
</p>

@endsection