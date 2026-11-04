@extends('layouts.shop')

@section('title', 'Ruiz - Watch Collection')

@section('content')
    <!-- container -->
    <div class="container py-4" style="font-family: 'Domine', serif;">

        <!-- Category Filter Bar -->
        @auth
            <div class="d-flex justify-content-center flex-wrap gap-2 mb-4" style="margin-top: 70px;">
                <a href="{{ route('shop.index') }}"
                    class="btn btn-sm {{ !request('category') ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' }} px-3 rounded-pill">
                    All Brands
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                        class="btn btn-sm {{ request('category') == $category->id ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' }} px-3 rounded-pill">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endauth

        <!-- Section Title -->
        <div class="d-flex justify-content-between align-items-center mb-3" id="shop-products">
            <h5 class="fw-bold text-dark mb-0" style="font-family: 'Crimson Text', serif;">
                <i class="fa-solid fa-clock me-2 text-warning"></i> Watches Collection
            </h5>
            @guest
                <span class="text-muted small">Showing Top Products (Login to view categories)</span>
            @endguest
        </div>

        <!-- Products Grid -->
        <div class="product-grid-5">
            @forelse($products as $product)
                @php
                    $stock = $product->inventory->stock_quantity ?? 0;
                @endphp
                <div class="product-item">
                    <div class="card h-100 border shadow-sm rounded-4 overflow-hidden position-relative bg-white p-2">

                        <!-- Top Category / Brand Badge -->
                        <div class="position-absolute top-0 start-0 m-2 z-index-1">
                            <span class="badge bg-success text-white px-2 py-1"
                                style="font-size: 10px; border-radius: 4px;">
                                {{ $product->category->name ?? 'Watch' }}
                            </span>
                        </div>

                        <!-- Stock Badge -->
                        <div class="position-absolute top-0 end-0 m-2 z-index-1">
                            @if ($stock == 0)
                                <span class="badge bg-danger p-1" style="font-size: 9px;">Out</span>
                            @elseif ($stock < 3)
                                <span class="badge bg-warning text-dark p-1" style="font-size: 9px;">Low</span>
                            @else
                                <span class="badge bg-secondary text-white p-1" style="font-size: 9px;">In Stock</span>
                            @endif
                        </div>

                        <!-- Product Image Container -->
                        <div class="bg-black rounded-3 overflow-hidden d-flex align-items-center justify-content-center"
                            style="height: 175px;">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100"
                                    alt="{{ $product->name }}" style="object-fit: cover;">
                            @else
                                <div class="text-white-50">
                                    <i class="fa-solid fa-image fa-2x"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column px-1 py-3 text-start">

                            <!-- Product Title -->
                            <h6 class="card-title text-center fw-bold text-dark mb-1 text-truncate" style="font-size: 14px;"
                                title="{{ $product->name }}">
                                {{ $product->name }}
                            </h6>

                            <!-- Description & See Details (Slug Binding) -->
                            <p class="text-muted mb-1"
                                style="font-size: 13px; line-height: 1.5; overflow: hidden; margin-top: 5px; font-family: 'Albert Sans', sans-serif;">
                                {{ Str::limit($product->description, 50, '...') }}
                                <a href="{{ route('shop.show', $product) }}"
                                    class="text-primary text-decoration-none fw-semibold" style="font-size: 11px;">
                                    See Details
                                </a>
                            </p>

                            <!-- Price & Quantity Selector -->
                            <div class="d-flex align-items-center justify-content-between my-3">
                                <!-- Price -->
                                <div class="text-dark fw-bold" style="font-size: 14px;">
                                    ${{ number_format($product->price, 2) }}
                                </div>

                                <!-- Quantity Selector (- / + Buttons) -->
                                <div class="input-group input-group-sm" style="width: 95px;">
                                    <button class="btn btn-outline-danger px-2 py-0 fw-bold" type="button"
                                        onclick="decrementQty(this)" style="font-size: 15px; line-height: 1.5;">-</button>
                                    <input type="text" class="form-control text-center px-1 py-0 bg-white fw-bold"
                                        value="1" readonly style="font-size: 13px;">
                                    <button class="btn btn-outline-success px-2 py-0 fw-bold" type="button"
                                        onclick="incrementQty(this, {{ $stock }})"
                                        style="font-size: 15px; line-height: 1.5;">+</button>
                                </div>
                            </div>

                            <!-- Dynamic Action Button -->
                            <div class="mt-auto">
                                @guest
                                    <button type="button" onclick="showRegisterAlert('{{ route('register') }}')"
                                        class="btn btn-success btn-sm w-100 rounded-pill fw-semibold text-white text-decoration-none shadow-sm border-0"
                                        style="font-size: 12px; padding: 5px;">
                                        Buy Now
                                    </button>
                                @endguest

                                @auth
                                    @if ($stock > 0)
                                        <button class="btn btn-success btn-sm w-100 rounded-pill fw-semibold text-white shadow-sm"
                                            style="font-size: 12px; padding: 5px;">
                                            <i class="fa-solid fa-cart-shopping me-1"></i> Add to Cart
                                        </button>
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100 rounded-pill fw-semibold text-white shadow-sm"
                                            style="font-size: 12px; padding: 5px;" disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted py-5">
                        <i class="fa-solid fa-box-open fa-3x mb-3"></i>
                        <h6>No watches available at the moment.</h6>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Custom CSS -->
    <style>
        @media (min-width: 992px) {
            .product-grid-5 {
                display: flex;
                flex-wrap: wrap;
                margin-right: -6px;
                margin-left: -6px;
            }

            .product-grid-5>.product-item {
                flex: 0 0 20%;
                max-width: 20%;
                padding-right: 6px;
                padding-left: 6px;
                margin-bottom: 16px;
            }
        }

        @media (max-width: 991px) and (min-width: 576px) {
            .product-grid-5 {
                display: flex;
                flex-wrap: wrap;
                margin-right: -6px;
                margin-left: -6px;
            }

            .product-grid-5>.product-item {
                flex: 0 0 33.333%;
                max-width: 33.333%;
                padding-right: 6px;
                padding-left: 6px;
                margin-bottom: 12px;
            }
        }

        @media (max-width: 575px) {
            .product-grid-5>.product-item {
                margin-bottom: 12px;
            }
        }

        .card {
            width: 100%;
            margin: 0 auto;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1) !important;
        }
    </style>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function incrementQty(btn, maxStock) {
            let input = btn.previousElementSibling;
            let currentValue = parseInt(input.value);

            if (maxStock === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Out of Stock',
                    text: 'Sorry, this watch is currently out of stock.',
                    confirmButtonColor: '#343a40',
                    timer: 2000
                });
                return;
            }

            if (currentValue < maxStock) {
                input.value = currentValue + 1;
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Stock Limit Reached',
                    text: 'The requested quantity exceeds available stock (' + maxStock + ' units left).',
                    confirmButtonColor: '#343a40',
                    confirmButtonText: 'OK'
                });
            }
        }

        function decrementQty(btn) {
            let input = btn.nextElementSibling;
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }

        function showRegisterAlert(registerUrl) {
            if (typeof Swal === 'undefined') {
                alert('Account Required! Please register first to purchase products.');
                window.location.href = registerUrl;
                return;
            }

            Swal.fire({
                title: 'Account Required!',
                text: 'Please register first to purchase products.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Register Now',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = registerUrl;
                }
            });
        }
    </script>
@endsection
