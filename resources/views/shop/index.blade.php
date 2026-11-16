@extends('layouts.shop')

@section('title', 'Ruiz - Watch Collection')

@section('content')
    <!-- container -->
    <div class="container py-4" style="font-family: 'Domine', serif;">

        <!-- Category Filter Bar -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-2" style="margin-top: 70px;" id="back-to-collection">
            <a href="{{ route('shop.index') }}"
                class="btn btn-sm category-filter-btn {{ !request('category') ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' }} px-3 rounded-pill"
                data-category="">
                All Brands
            </a>

            @foreach ($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                    class="btn btn-sm category-filter-btn {{ request('category') == $category->id ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' }} px-3 rounded-pill"
                    data-category="{{ $category->id }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Gender Filter Bar (Men, Women, Unisex) -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
            <a href="{{ route('shop.index') }}"
                class="btn btn-sm gender-filter-btn {{ !request('gender') ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' }} px-3 rounded-pill"
                style="font-size: 12px;" data-gender="">
                All Genders
            </a>
            <a href="{{ route('shop.index', ['gender' => 'men']) }}"
                class="btn btn-sm gender-filter-btn {{ request('gender') == 'men' ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' }} px-3 rounded-pill"
                style="font-size: 12px;" data-gender="men">
                Men
            </a>
            <a href="{{ route('shop.index', ['gender' => 'women']) }}"
                class="btn btn-sm gender-filter-btn {{ request('gender') == 'women' ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' }} px-3 rounded-pill"
                style="font-size: 12px;" data-gender="women">
                Women
            </a>
            <a href="{{ route('shop.index', ['gender' => 'unisex']) }}"
                class="btn btn-sm gender-filter-btn {{ request('gender') == 'unisex' ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' }} px-3 rounded-pill"
                style="font-size: 12px;" data-gender="unisex">
                Unisex
            </a>
        </div>

        <!-- Section Title -->
        <div class="d-flex justify-content-between align-items-center mb-3" id="shop-products">
            <h5 class="fw-bold text-dark mb-0" style="font-family: 'Crimson Text', serif;">
                <i class="fa-solid fa-clock me-2 text-warning"></i> Watches Collection
            </h5>
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

                        <!--  Stock & Wishlist Icons  -->
                        <div class="position-absolute top-0 end-0 m-2 z-index-1 d-flex align-items-center gap-1">
                            <!-- Stock Badge -->
                            @if ($stock == 0)
                                <span class="badge bg-danger p-1" style="font-size: 9px;">Out</span>
                            @elseif ($stock < 3)
                                <span class="badge bg-warning text-dark p-1" style="font-size: 9px;">Low</span>
                            @else
                                <span class="badge bg-secondary text-white p-1" style="font-size: 9px;">In Stock</span>
                            @endif

                            <!-- Wishlist Heart Button -->
                            @php
                                $isWishlisted = false;
                                if (auth()->check()) {
                                    $isWishlisted = auth()
                                        ->user()
                                        ->wishlists()
                                        ->where('product_id', $product->id)
                                        ->exists();
                                } else {
                                    $wishlistSession = session()->get('wishlist', []);
                                    $isWishlisted = in_array($product->id, $wishlistSession);
                                }
                            @endphp
                            <button type="button"
                                class="btn btn-light btn-sm rounded-circle p-1 d-flex align-items-center justify-content-center wishlist-btn shadow-sm"
                                style="width: 26px; height: 26px; background: rgba(255, 255, 255, 0.9); border: 1px solid #ddd;"
                                data-product-id="{{ $product->id }}" title="Wishlist">
                                <i class="{{ $isWishlisted ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart text-dark' }}"
                                    style="font-size: 12px;"></i>
                            </button>
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
                            <!-- Product Name -->
                            <h6 class="card-title text-center fw-bold text-dark mb-1 text-truncate" style="font-size: 14px;"
                                title="{{ $product->name }}">
                                {{ $product->name }}
                            </h6>

                            <!-- Product Description -->
                            <p class="text-muted mb-2"
                                style="font-size: 12px; line-height: 1.4; overflow: hidden; margin-top: 2px; font-family: 'Albert Sans', sans-serif;">
                                {{ Str::limit($product->description, 50, '...') }}
                                <a href="{{ route('shop.show', $product) }}"
                                    class="text-primary text-decoration-none fw-semibold" style="font-size: 11px;">
                                    More
                                </a>
                            </p>

                            <!-- Rating -->
                            @php
                                $cardAvgRating = $product->ratings()->avg('rating') ?? 0;
                                $cardRatingCount = $product->ratings()->count();
                            @endphp
                            <div class="d-flex align-items-center justify-content-end gap-1 mb-2" style="font-size: 10px;">
                                <div class="text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($cardAvgRating))
                                            <i class="fa-solid fa-star" style="font-size: 13px;"></i>
                                        @else
                                            <i class="fa-regular fa-star" style="font-size: 13px;"></i>
                                        @endif
                                    @endfor
                                </div>
                                {{-- <span class="fw-bold text-dark">{{ number_format($cardAvgRating, 1) }}</span> --}}
                                {{-- <span class="text-muted">({{ $cardRatingCount }})</span> --}}
                            </div>

                            <!-- Price & Quantity Section -->
                            <div class="d-flex align-items-center justify-content-between my-2">
                                <div class="text-dark fw-bold" style="font-size: 14px;">
                                    ${{ number_format($product->price, 2) }}
                                </div>

                                <div class="input-group input-group-sm" style="width: 90px;">
                                    <button class="btn btn-outline-danger px-2 py-0 fw-bold" type="button"
                                        onclick="decrementQty(this)" style="font-size: 14px; line-height: 1.5;">-</button>
                                    <input type="text" class="form-control text-center px-1 py-0 bg-white fw-bold"
                                        value="1" readonly style="font-size: 12px;">
                                    <button class="btn btn-outline-success px-2 py-0 fw-bold" type="button"
                                        onclick="incrementQty(this, {{ $stock }})"
                                        style="font-size: 14px; line-height: 1.5;">+</button>
                                </div>
                            </div>

                            <!-- Add to Cart Form -->
                            <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1" class="cart-qty-input">
                                <div class="mt-auto">
                                    @if ($stock > 0)
                                        <button
                                            class="btn btn-success btn-sm w-100 rounded-pill fw-semibold text-white shadow-sm"
                                            style="font-size: 12px; padding: 5px;">
                                            <i class="fa-solid fa-cart-shopping me-1"></i> Add to Cart
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-secondary btn-sm w-100 rounded-pill fw-semibold text-white shadow-sm"
                                            style="font-size: 12px; padding: 5px;" disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </form>

                            <!-- Comments Link at the bottom -->
                            <div class="mt-2 pt-2 border-top text-start">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 12px;">
                                    <a href="{{ route('shop.show', $product) }}"
                                        class="text-dark text-decoration-none d-flex align-items-center justify-content-between">
                                        <span>
                                            <i class="fa-solid fa-comments me-1 text-warning"></i> Comments
                                        </span>
                                        <span class="text-muted fw-normal">({{ $product->comments->count() }})</span>
                                    </a>
                                </h6>
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

    <!-- Custom CSS & Scripts -->
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
                let formQtyInput = btn.closest('.card-body').querySelector('.cart-qty-input');
                if (formQtyInput) {
                    formQtyInput.value = input.value;
                }
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Stock Limit Reached',
                    text: 'The requested quantity exceeds available stock (' + maxStock + ' units left).',
                    confirmButtonColor: '#343a40'
                });
            }
        }

        function decrementQty(btn) {
            let input = btn.nextElementSibling;
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                let formQtyInput = btn.closest('.card-body').querySelector('.cart-qty-input');
                if (formQtyInput) {
                    formQtyInput.value = input.value;
                }
            }
        }

        function updateActiveFilters(searchUrl) {
            let fullUrl = new URL(searchUrl, window.location.origin);
            let currentCategory = fullUrl.searchParams.get('category') || "";
            let currentGender = fullUrl.searchParams.get('gender') || "";

            document.querySelectorAll('.category-filter-btn').forEach(btn => {
                let btnCat = btn.getAttribute('data-category');
                if (btnCat === currentCategory) {
                    btn.classList.remove('btn-outline-dark');
                    btn.classList.add('btn-warning', 'text-dark', 'fw-bold');
                } else {
                    btn.classList.remove('btn-warning', 'text-dark', 'fw-bold');
                    btn.classList.add('btn-outline-dark');
                }
            });

            document.querySelectorAll('.gender-filter-btn').forEach(btn => {
                let btnGen = btn.getAttribute('data-gender');
                if (btnGen === currentGender) {
                    btn.classList.remove('btn-outline-dark');
                    btn.classList.add('btn-warning', 'text-dark', 'fw-bold');
                } else {
                    btn.classList.remove('btn-warning', 'text-dark', 'fw-bold');
                    btn.classList.add('btn-outline-dark');
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const filterButtons = document.querySelectorAll('.category-filter-btn, .gender-filter-btn');

            filterButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    let currentUrl = new URL(window.location.href);
                    let params = new URLSearchParams(currentUrl.search);

                    if (this.classList.contains('category-filter-btn')) {
                        let selectedCategory = this.getAttribute('data-category');
                        if (selectedCategory) {
                            params.set('category', selectedCategory);
                        } else {
                            params.delete('category');
                        }
                    }

                    if (this.classList.contains('gender-filter-btn')) {
                        let selectedGender = this.getAttribute('data-gender');
                        if (selectedGender) {
                            params.set('gender', selectedGender);
                        } else {
                            params.delete('gender');
                        }
                    }

                    let requestUrl = "{{ route('shop.index') }}" + (params.toString() ? '?' + params.toString() : '');

                    fetch(requestUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.querySelector('.product-grid-5').outerHTML = html;
                        window.history.pushState({}, '', requestUrl);
                        updateActiveFilters(requestUrl);
                    })
                    .catch(error => console.error('Error:', error));
                });
            });

            document.addEventListener('click', function(e) {
                let wishlistBtn = e.target.closest('.wishlist-btn');
                if (!wishlistBtn) return;

                e.preventDefault();
                let productId = wishlistBtn.getAttribute('data-product-id');
                let icon = wishlistBtn.querySelector('i');

                fetch("{{ route('wishlist.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    let wishlistCountEl = document.getElementById('wishlist-count');
                    if (wishlistCountEl) {
                        wishlistCountEl.textContent = data.wishlistCount;
                    }

                    if (data.status === 'added') {
                        icon.classList.remove('fa-regular', 'text-dark', 'text-white');
                        icon.classList.add('fa-solid', 'text-danger');
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Wishlist',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1200,
                            toast: true,
                            position: 'top-end'
                        });
                    } else {
                        icon.classList.remove('fa-solid', 'text-danger');
                        icon.classList.add('fa-regular', 'text-dark');
                        Swal.fire({
                            icon: 'info',
                            title: 'Removed from Wishlist',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1200,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            window.addEventListener('popstate', function() {
                updateActiveFilters(window.location.href);
            });

            const cartForms = document.querySelectorAll('.add-to-cart-form');
            cartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);

                    fetch("{{ route('cart.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "X-Requested-With": "XMLHttpRequest",
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let cartCountEl = document.getElementById('cart-count');
                            if (cartCountEl) {
                                cartCountEl.textContent = data.cartCount;
                            }
                            Swal.fire({
                                icon: 'success',
                                title: 'Added to Cart',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500,
                                toast: true,
                                position: 'top-end'
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
