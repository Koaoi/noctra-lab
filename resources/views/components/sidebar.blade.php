<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <h5>NOCTRA LAB</h5>
        <small>Admin Panel</small>
    </div>

    <nav class="py-2">
        <div class="sidebar-section-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            ▪ Dashboard
        </a>

        <div class="sidebar-section-label mt-2">Catalog</div>
        <a href="{{ route('admin.products.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            ▪ Products
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            ▪ Categories
        </a>

        <div class="sidebar-section-label mt-2">Sales</div>
        <a href="{{ route('admin.orders.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            ▪ Orders
        </a>
        <a href="{{ route('admin.commissions.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.commissions.*') ? 'active' : '' }}">
            ▪ Commissions
        </a>

        <div class="sidebar-section-label mt-2">Community</div>
        <a href="{{ route('admin.users.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            ▪ Users
        </a>
        <a href="{{ route('admin.reviews.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            ▪ Reviews
        </a>

        <div class="sidebar-section-label mt-2">Account</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link w-100 text-start border-0 bg-transparent"
                    style="cursor: pointer;">
                ▪ Logout
            </button>
        </form>
    </nav>
</aside>