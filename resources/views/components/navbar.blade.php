<nav class="noctra-navbar navbar navbar-expand-lg">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            NOCTRA<span style="color: var(--noctra-gray)">LAB</span>
        </a>

        {{-- Toggler mobile --}}
        <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#mainNav"
            style="color: var(--noctra-white)">
            <span style="font-size: 1.5rem;">☰</span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            {{-- Left nav --}}
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                       href="{{ route('products.index') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('commission.*') ? 'active' : '' }}"
                       href="{{ route('commission.index') }}">Commission</a>
                </li>
            </ul>

            {{-- Right nav --}}
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                @auth
                    {{-- Wishlist --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('wishlist.index') }}">Wishlist</a>
                    </li>

                    {{-- Cart --}}
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="{{ route('cart.index') }}">
                            Cart
                            @if(session('cart_count', 0) > 0)
                                <span class="cart-badge">{{ session('cart_count') }}</span>
                            @endif
                        </a>
                    </li>

                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ Str::limit(auth()->user()->name, 12) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a>
                            </li>
                            @if(auth()->user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider" style="border-color: var(--noctra-border);"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-noctra ms-2" href="{{ route('register') }}"
                           style="padding: 0.5rem 1.25rem; font-size: 11px;">
                            Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>