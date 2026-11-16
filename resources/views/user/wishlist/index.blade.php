@extends('layouts.shop')

@section('title', 'Ruiz - My Wishlist')

@section('content')
    <!-- container -->
    <div class="container py-4" style="font-family: 'Domine', serif;">

        <!-- Section Title -->
        <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 70px;">
            <h5 class="fw-bold text-dark mb-0" style="font-family: 'Crimson Text', serif;">
                <i class="fa-solid fa-heart me-2 text-danger"></i> My Wishlist Products
            </h5>
            <a href="{{ route('shop.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3" style="font-size: 13px;">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Shop
            </a>
        </div>

        <!-- Products Grid -->
        <div class="product-grid-5">
            @forelse($products as $product)
                @php
                    $stock = $product->inventory->stock_quantity ?? 0;
                @endphp
                <div class="product-item" id="wishlist-item-{{ $product->id }}">
                    <div class="card h-100 border shadow-sm rounded-4 overflow-hidden position-relative bg-white p-2">

                        <!-- Top Category / Brand Badge -->
                        <div class="position-absolute top-0 start-0 m-2 z-index-1">
                            <span class="badge bg-success text-white px-2 py-1"
                                style="font-size: 10px; border-radius: 4px;">
                                {{ $product->category->name ?? 'Watch' }}
                            </span>
                        </div>

                        <!-- Stock & Remove (Wishlist) Button -->
                        <div class="position-absolute top-0 end-0 m-2 z-index-1 d-flex align-items-center gap-1">
                            <!-- Stock Badge -->
                            @if ($stock == 0)
                                <span class="badge bg-danger p-1" style="font-size: 9px;">Out</span>
                            @elseif ($stock < 3)
                                <span class="badge bg-warning text-dark p-1" style="font-size: 9px;">Low</span>
                            @else
                                <span class="badge bg-secondary text-white p-1" style="font-size: 9px;">In Stock</span>
                            @endif

                            <!-- Remove / Wishlist Heart Button -->
                            <button type="button"
                                class="btn btn-light btn-sm rounded-circle p-1 d-flex align-items-center justify-content-center wishlist-btn shadow-sm"
                                style="width: 26px; height: 26px; background: rgba(255, 255, 255, 0.9); border: 1px solid #ddd;"
                                data-product-id="{{ $product->id }}" title="Remove from Wishlist">
                                <i class="fa-solid fa-heart text-danger" style="font-size: 12px;"></i>
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
                            <h6 class="card-title text-center fw-bold text-dark mb-1 text-truncate" style="font-size: 14px;"
                                title="{{ $product->name }}">
                                {{ $product->name }}
                            </h6>

                            <p class="text-muted mb-1"
                                style="font-size: 13px; line-height: 1.5; overflow: hidden; margin-top: 5px; font-family: 'Albert Sans', sans-serif;">
                                {{ Str::limit($product->description, 50, '...') }}
                                <a href="{{ route('shop.show', $product) }}"
                                    class="text-primary text-decoration-none fw-semibold" style="font-size: 11px;">
                                    See Details
                                </a>
                            </p>

                            <div class="d-flex align-items-center justify-content-between my-3">
                                <div class="text-dark fw-bold" style="font-size: 14px;">
                                    ${{ number_format($product->price, 2) }}
                                </div>

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
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted py-5">
                        <i class="fa-regular fa-heart fa-3x mb-3 text-secondary"></i>
                        <h5 class="fw-bold text-dark">Your wishlist is empty</h5>
                        <p class="text-muted small mb-4">Explore our watch collection and save your favorite timepieces
                            here.</p>
                        <a href="{{ route('shop.index') }}"
                            class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm">
                            Discover Watches
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Custom CSS (Shop page နဲ့ ပုံစံတူ Layout အတွက်) -->
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

    <!-- SweetAlert2 & AJAX Scripts -->
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
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,
                    position: 'top-end'
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
                    text: 'Max available stock is ' + maxStock + ' units.',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,
                    position: 'top-end'
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
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Minimum Quantity',
                    text: 'Quantity cannot be less than 1.',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,
                    position: 'top-end'
                });
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // 1. Wishlist AJAX Toggle (Remove item when heart clicked on wishlist page)
            document.addEventListener('click', function(e) {
                let wishlistBtn = e.target.closest('.wishlist-btn');
                if (!wishlistBtn) return;

                e.preventDefault();
                let productId = wishlistBtn.getAttribute('data-product-id');
                let productCardItem = document.getElementById('wishlist-item-' + productId);

                fetch("{{ route('wishlist.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update header wishlist badge count
                        let wishlistCountEl = document.getElementById('wishlist-count');
                        if (wishlistCountEl) {
                            wishlistCountEl.textContent = data.wishlistCount;
                        }

                        // If removed, fade out and remove the product card from the grid smoothly
                        if (data.status === 'removed' && productCardItem) {
                            productCardItem.style.transition = "all 0.3s ease";
                            productCardItem.style.opacity = "0";
                            productCardItem.style.transform = "scale(0.9)";
                            setTimeout(() => {
                                productCardItem.remove();
                                // If no items left, reload or show empty state if needed
                                if (document.querySelectorAll('.product-item').length === 0) {
                                    location.reload();
                                }
                            }, 300);

                            Swal.fire({
                                icon: 'info',
                                title: 'Removed',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1000,
                                toast: true,
                                position: 'top-end'
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            // 2. Add to Cart AJAX Logic
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
