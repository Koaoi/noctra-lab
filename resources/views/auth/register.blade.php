@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; background: var(--noctra-black); padding: 3rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                {{-- Header --}}
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}"
                       style="font-size: 1.5rem; font-weight: 900; letter-spacing: .1em; text-transform: uppercase; color: var(--noctra-white); text-decoration: none;">
                        NOCTRA<span style="color: var(--noctra-gray)">LAB</span>
                    </a>
                    <p class="noctra-label mt-3">Create your account</p>
                </div>

                {{-- Card --}}
                <div style="background: var(--noctra-card); border: 1px solid var(--noctra-border); padding: 2rem;">

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div style="background: rgba(229,62,62,0.1); border: 1px solid rgba(229,62,62,0.3);
                                    padding: .875rem 1rem; margin-bottom: 1.5rem;">
                            <ul class="mb-0 ps-3" style="font-size: 13px; color: #fc8181;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label-noctra">Full Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control form-control-noctra @error('name') is-invalid @enderror"
                                   placeholder="Your name"
                                   autocomplete="name"
                                   required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label-noctra">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control form-control-noctra @error('email') is-invalid @enderror"
                                   placeholder="your@email.com"
                                   autocomplete="email"
                                   required>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label-noctra">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control form-control-noctra @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 characters"
                                   autocomplete="new-password"
                                   required>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-4">
                            <label class="form-label-noctra">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control form-control-noctra"
                                   placeholder="Repeat password"
                                   autocomplete="new-password"
                                   required>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-noctra w-100" style="display:block; text-align:center;">
                            Create Account
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="d-flex align-items-center my-4 gap-3">
                        <hr style="flex:1; border-color: var(--noctra-border);">
                        <span style="font-size: 11px; color: var(--noctra-gray); text-transform: uppercase; letter-spacing: .08em;">
                            or
                        </span>
                        <hr style="flex:1; border-color: var(--noctra-border);">
                    </div>

                    {{-- Google OAuth --}}
                    <a href="{{ route('google.redirect') }}"
                       class="btn-noctra-outline w-100 d-flex align-items-center justify-content-center gap-2"
                       style="padding: .7rem 1rem;">
                        <svg width="18" height="18" viewBox="0 0 48 48" fill="none">
                            <path d="M47.5 24.6c0-1.6-.1-3.1-.4-4.6H24v8.7h13.2c-.6 3-2.4 5.5-5 7.2v6h8c4.7-4.3 7.3-10.7 7.3-17.3z" fill="#4285F4"/>
                            <path d="M24 48c6.5 0 11.9-2.1 15.9-5.8l-8-6c-2.1 1.4-4.8 2.2-7.9 2.2-6.1 0-11.2-4.1-13.1-9.6H2.7v6.2C6.7 42.6 14.8 48 24 48z" fill="#34A853"/>
                            <path d="M10.9 28.8c-.5-1.4-.8-2.9-.8-4.4 0-1.6.3-3.1.8-4.4v-6.2H2.7C1 17 0 20.4 0 24.4s1 7.4 2.7 10.6l8.2-6.2z" fill="#FBBC05"/>
                            <path d="M24 9.5c3.4 0 6.5 1.2 8.9 3.5l6.6-6.6C35.9 2.4 30.5 0 24 0 14.8 0 6.7 5.4 2.7 13.4l8.2 6.2C12.8 13.6 17.9 9.5 24 9.5z" fill="#EA4335"/>
                        </svg>
                        Continue with Google
                    </a>

                    {{-- Login Link --}}
                    <p class="text-center mt-4 mb-0" style="font-size: 13px; color: var(--noctra-gray);">
                        Already have an account?
                        <a href="{{ route('login') }}"
                           style="color: var(--noctra-white); font-weight: 600;">
                            Login
                        </a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection