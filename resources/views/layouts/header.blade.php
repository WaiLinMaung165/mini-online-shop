<!-- Header Start -->
<header class="header-main fixed-top">
    <div class="container">
        <div class="row align-items-center gy-2">

            <!-- 1. Logo (col-lg-2) -->
            <div class="col-lg-2 col-6">
                <a href="{{ route('shop.index') }}" class="brand-logo">
                    <i class="fa-regular fa-clock me-1 text-gold"></i>ruiz<span>.</span>
                </a>
            </div>

            <!-- 2. Navigation Links (col-lg-4) -->
            <div class="col-lg-4 order-3 order-lg-2" style="font-family: 'Crimson Text', serif;">
                <ul class="nav justify-content-center main-nav-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('shop.index') ? 'active text-warning' : '' }}"
                            href="{{ route('shop.index') }}">Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
            </div>

            <!-- 3. Search Bar (col-lg-3) -->
            <div class="col-lg-3 col-12 order-4 order-lg-3 my-1 my-lg-0">
                <form action="{{ route('shop.index') }}#shop-products" method="GET" class="d-flex">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control bg-dark text-white border-secondary"
                            placeholder="Search watches..." value="{{ request('search') }}"
                            style="font-family: 'Crimson Text', serif;">
                        <button class="btn btn-outline-warning" type="submit">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- 4. Icons & Auth Buttons (col-lg-3) -->
            <div class="col-lg-3 col-6 order-2 order-lg-4 text-end">
                <div class="header-icons d-flex align-items-center justify-content-end gap-3">

                    <a href="{{ route('wishlist.index') }}" title="Wishlist"
                        class="text-decoration-none {{ Request::routeIs('wishlist.index') ? 'text-warning fw-bold' : 'text-white' }} position-relative">
                        <i class="fa-solid fa-heart"></i>
                        <span class="badge-count bg-danger" id="wishlist-count">
                            @auth
                                {{ Auth::user()->wishlists()->count() }}
                            @else
                                {{ session('wishlist') ? count(session('wishlist')) : 0 }}
                            @endauth
                        </span>
                    </a>

                    <a href="{{ route('cart.index') }}" title="Shopping Cart"
                        class="{{ Request::routeIs('cart.index') ? 'text-warning fw-bold' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="badge-count bg-success" id="cart-count">
                            {{ session('cart') ? collect(session('cart'))->sum('quantity') : 0 }}
                        </span>
                    </a>

                    <div class="vr bg-secondary d-none d-sm-block" style="height: 20px; opacity: 0.4;"></div>

                    @guest
                        <div class="d-flex align-items-center gap-2 ms-1" style="font-family: 'Crimson Text', serif;">
                            <button type="button" class="btn btn-link text-white text-decoration-none p-0 me-2"
                                data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 15px;">Login</button>
                            <button type="button" class="btn btn-link text-white text-decoration-none p-0 me-2"
                                data-bs-toggle="modal" data-bs-target="#registerModal"
                                style="font-size: 14px;">Register</button>
                        </div>
                    @endguest

                    @auth
                        <div class="dropdown">
                            <a href="#"
                                class="d-flex align-items-center text-decoration-none text-white dropdown-toggle"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-warning me-2"
                                    style="width: 35px; height: 35px; background-color: rgba(255, 193, 7, 0.1) !important; border: 1px solid rgba(255, 193, 7, 0.3);">
                                    <i class="fa-solid fa-user" style="font-size: 14px;"></i>
                                </div>
                                <span class="text-white fw-semibold"
                                    style="font-size: 15px; font-family: 'Crimson Text', serif;">{{ Auth::user()->name }}</span>
                            </a>

                            <!-- Dropdown Menu -->
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow"
                                aria-labelledby="userDropdown" style="font-family: 'Crimson Text', serif;">
                                <li>
                                    <a class="dropdown-item py-2 text-white" href="{{ route('orders.index') }}"
                                        style="font-size: 15px;">
                                        <i class="fa-solid fa-box-archive me-2 text-warning"></i>My Orders
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider border-secondary">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-white">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</header>
<!-- Header End -->
