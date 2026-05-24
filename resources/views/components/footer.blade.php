<footer class="noctra-footer">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <h6>NOCTRA LAB</h6>
                <p style="font-size:13px; line-height:1.7; color: var(--noctra-gray);">
                    Limited fashion drop &amp; commission store.<br>
                    Korean streetwear. Dark aesthetic. Premium quality.
                </p>
            </div>
            <div class="col-md-2">
                <h6>Shop</h6>
                <ul class="list-unstyled" style="font-size:13px;">
                    <li><a href="{{ route('products.index') }}" style="color:var(--noctra-gray);">All Products</a></li>
                    <li><a href="{{ route('commission.index') }}" style="color:var(--noctra-gray);">Commission</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Account</h6>
                <ul class="list-unstyled" style="font-size:13px;">
                    @auth
                        <li><a href="{{ route('orders.index') }}" style="color:var(--noctra-gray);">My Orders</a></li>
                        <li><a href="{{ route('wishlist.index') }}" style="color:var(--noctra-gray);">Wishlist</a></li>
                    @else
                        <li><a href="{{ route('login') }}" style="color:var(--noctra-gray);">Login</a></li>
                        <li><a href="{{ route('register') }}" style="color:var(--noctra-gray);">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
        <hr style="border-color: var(--noctra-border); margin: 1.5rem 0;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <p class="mb-0" style="font-size:12px;">
                © {{ date('Y') }} NOCTRA LAB. All rights reserved.
            </p>
            <p class="mb-0" style="font-size:12px; letter-spacing:.06em; text-transform:uppercase;">
                Dark. Limited. Exclusive.
            </p>
        </div>
    </div>
</footer>