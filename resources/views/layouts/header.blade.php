<!-- Header Start -->
<header class="header-main">
    <div class="container">
        <div class="row align-items-center gy-3">

            <!-- Logo -->
            <div class="col-lg-2 col-6">
                <a href="{{ route('shop.index') }}" class="brand-logo">
                    <i class="fa-regular fa-clock me-1 text-gold"></i>ruiz<span>.</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="col-lg-6 order-3 order-lg-2" style="font-family: 'Crimson Text', serif;">
                <ul class="nav justify-content-center main-nav-menu">
                    <li class="nav-item"><a class="nav-link active text-warning"
                            href="{{ route('shop.index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
            </div>

            <!-- Icons & Auth Buttons -->
            <div class="col-lg-4 col-6 order-2 order-lg-3 text-end">
                <div class="header-icons d-flex align-items-center justify-content-end gap-3">
                    <a href="#" title="Wishlist"><i class="fa-regular fa-heart"></i><span
                            class="badge-count">0</span></a>
                    <a href="#" title="Shopping Cart"><i class="fa-solid fa-bag-shopping"></i><span
                            class="badge-count" id="cart-count">2</span></a>
                    <div class="vr bg-secondary d-none d-sm-block" style="height: 20px; opacity: 0.4;"></div>
                    @guest
                        <div class="d-flex align-items-center gap-2 ms-1" style="font-family: 'Crimson Text', serif;">
                            <a href="{{ route('login') }}" class="btn-auth-login" style="font-size: 15px;">Login</a>
                            <a href="{{ route('register') }}" class="btn-auth-register"
                                style="font-size: 15px;">Register</a>
                        </div>
                    @endguest
                    @auth
                        <div class="dropdown">
                            <a href="#"
                                class="d-flex align-items-center text-decoration-name text-white dropdown-toggle"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- User Icon -->
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-warning me-2"
                                    style="width: 35px; height: 35px; background-color: rgba(255, 193, 7, 0.1) !important; border: 1px solid rgba(255, 193, 7, 0.3);">
                                    <i class="fa-solid fa-user" style="font-size: 14px;"></i>
                                </div>
                                <!-- User Name -->
                                <span class="text-white fw-semibold"
                                    style="font-size: 15px; font-family: 'Crimson Text', serif;">{{ Auth::user()->name }}</span>
                            </a>

                            <!-- Dropdown Menu -->
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow"
                                aria-labelledby="userDropdown" style="font-family: 'Crimson Text', serif;">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-primary"><i
                                                class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
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
