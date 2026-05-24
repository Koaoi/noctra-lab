@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="container noctra-section">
    <h1 class="section-heading mb-4">{{ $product->name }}</h1>
    <p style="color:var(--noctra-gray)">Product detail — dibangun di Phase 5.</p>
</div>
@endsection