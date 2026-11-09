<!-- Header Start -->
<header class="header-main fixed-top">
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
                    <!-- Login Menu -->
                    <li class="nav-item"><a
                            class="nav-link {{ Request::routeIs('shop.index') ? 'active text-warning' : '' }}"
                            href="{{ route('shop.index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
            </div>

            <!-- Icons & Auth Buttons -->
            <div class="col-lg-4 col-6 order-2 order-lg-3 text-end">
                <div class="header-icons d-flex align-items-center justify-content-end gap-3">
                    {{-- <a href="#" title="Wishlist"><i class="fa-regular fa-heart"></i><span
                            class="badge-count">0</span></a> --}}
                    <a href="{{ route('cart.index') }}" title="Shopping Cart"
                        class="{{ Request::routeIs('cart.index') ? 'text-warning fw-bold' : '' }}"><i
                            class="fa-solid fa-cart-shopping"></i><span class="badge-count bg-success"
                            id="cart-count">{{ session('cart') ? collect(session('cart'))->sum('quantity') : 0 }}</span></a>
                    <div class="vr bg-secondary d-none d-sm-block" style="height: 20px; opacity: 0.4;"></div>


                    @guest
                        <div class="d-flex align-items-center gap-2 ms-1" style="font-family: 'Crimson Text', serif;">
                            <!-- Login Modal Trigger -->
                            <button type="button" class="btn btn-link text-white text-decoration-none p-0 me-2"
                                data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 15px;">Login</button>

                            <!-- Register Modal Trigger -->
                            <button type="button" class="btn btn-link text-white text-decoration-none p-0 me-2"
                                data-bs-toggle="modal" data-bs-target="#registerModal"
                                style="font-size: 14px;">Register</button>
                        </div>
                    @endguest

                    @auth
                        <div class="dropdown">
                            <a href="#"
                                class="d-flex align-items-center text-decoration-name text-white dropdown-toggle"
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

                                <!-- My Orders Menu Item -->
                                <li>
                                    <a class="dropdown-item py-2 text-white" href="{{ route('orders.index') }}" style="font-size: 15px;">
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
