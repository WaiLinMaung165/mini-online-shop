@extends('layouts.shop')

@section('title', $product->name . ' - Ruiz Watches')

@section('content')
    <div class="container py-5" style="font-family: 'Domine', serif; margin-top: 60px;">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('shop.index') }}#back-to-collection" class="text-decoration-none text-dark fw-semibold" style="font-size: 14px;">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to Collection
            </a>
        </div>

        <div class="row g-4 align-items-stretch">

            <!-- Main Product Details (col-lg-8) -->
            <div class="col-lg-8">
                <div class="bg-white p-4 border shadow-sm rounded-4 h-100 d-flex flex-column justify-content-between">
                    <div class="row g-4 align-items-center">

                        <!-- Product Image Column -->
                        <div class="col-md-6">
                            <div class="bg-black rounded-4 overflow-hidden d-flex align-items-center justify-content-center position-relative shadow-sm" style="height: 500px;">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100" alt="{{ $product->name }}" style="object-fit: cover;">
                                @else
                                    <div class="text-white-50 text-center">
                                        <i class="fa-solid fa-image fa-3x mb-2"></i>
                                        <div class="small">No Image Available</div>
                                    </div>
                                @endif

                                <!-- Category & Gender Badges -->
                                <div class="position-absolute top-0 start-0 m-3 d-flex flex-column gap-1 z-index-1">
                                    <span class="badge bg-success text-white px-2 py-1" style="font-size: 11px; border-radius: 4px;">
                                        {{ $product->category->name ?? 'Watch' }}
                                    </span>

                                    @if($product->gender == 'men')
                                        <span class="badge bg-primary text-white px-2 py-1" style="font-size: 11px; border-radius: 4px;">Men</span>
                                    @elseif($product->gender == 'women')
                                        <span class="badge bg-danger text-white px-2 py-1" style="font-size: 11px; border-radius: 4px;">Women</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-2 py-1" style="font-size: 11px; border-radius: 4px;">Unisex</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Product Info Column -->
                        <div class="col-md-6 text-start d-flex flex-column justify-content-between" style="min-height: 480px;">
                            <div>
                                <h2 class="fw-bold text-dark mb-2" style="font-family: 'Crimson Text', serif; font-size: 26px;">
                                    {{ $product->name }}
                                </h2>

                                <!-- Stock Status & Total Stock Count -->
                                @php
                                    $stock = $product->inventory->stock_quantity ?? 0;
                                @endphp
                                <div class="mb-3 d-flex align-items-center flex-wrap gap-2">
                                    @if ($stock == 0)
                                        <span class="badge bg-danger px-2 py-1" style="font-size: 11px;">Out of Stock</span>
                                    @elseif ($stock < 3)
                                        <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 11px;">Low Stock ({{ $stock }} left)</span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1" style="font-size: 11px;">In Stock</span>
                                    @endif

                                    <span class="text-muted small" style="font-size: 12px;">
                                        (Available: <span class="text-dark fw-bold">{{ $stock }}</span> units)
                                    </span>
                                </div>

                                <!-- Price -->
                                <h3 class="text-success fw-bold mb-3" style="font-size: 26px;">
                                    ${{ number_format($product->price, 2) }}
                                </h3>

                                <hr class="text-muted my-3">

                                <!-- Description -->
                                <h6 class="fw-bold text-dark mb-2" style="font-size: 14px;">Description:</h6>
                                <p class="text-muted mb-4" style="font-family: 'Albert Sans', sans-serif; line-height: 1.7; font-size: 14px; min-height: 120px;">
                                    {{ $product->description ?? 'No detailed description available for this watch.' }}
                                </p>
                            </div>

                            <!-- Bottom Action Section -->
                            <div class="mt-auto">
                                <!-- Quantity Selector -->
                                @if ($stock > 0)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark small mb-1" style="font-size: 12px;">Quantity:</label>
                                        <div class="input-group input-group-sm" style="width: 130px;">
                                            <button class="btn btn-outline-danger px-3 py-1 fw-bold" type="button" onclick="decrementQty()">-</button>
                                            <input type="text" id="product-quantity" class="form-control text-center fw-bold bg-white px-1" value="1" readonly style="font-size: 14px;">
                                            <button class="btn btn-outline-success px-3 py-1 fw-bold" type="button" onclick="incrementQty({{ $stock }})">+</button>
                                        </div>
                                    </div>
                                @endif

                                <!-- Add to Cart Button -->
                                <div>
                                    @if ($stock > 0)
                                        <button class="btn btn-success btn-md rounded-pill fw-semibold text-white w-100 shadow-sm py-2" style="font-size: 14px;">
                                            <i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart
                                        </button>
                                    @else
                                        <button class="btn btn-secondary btn-md rounded-pill fw-semibold text-white w-100 shadow-sm py-2" style="font-size: 14px;" disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Watches (col-lg-4) -->
            <div class="col-lg-4 align-self-start">
                <div class="bg-white p-3 border shadow-sm rounded-4">
                    <h5 class="fw-bold text-dark mb-3" style="font-family: 'Crimson Text', serif; font-size: 18px;">
                        <i class="fa-solid fa-clock me-1 text-warning"></i> Related Watches
                    </h5>

                    <div class="d-flex flex-column gap-3">
                        @forelse($relatedProducts as $related)
                            @php
                                $relStock = $related->inventory->stock_quantity ?? 0;
                            @endphp
                            <div class="card border rounded-3 p-3 shadow-none related-card" style="min-height: 105px;">
                                <div class="row g-2 align-items-center h-100">
                                    <!-- Related Product Image -->
                                    <div class="col-4">
                                        <div class="bg-black rounded-2 overflow-hidden d-flex align-items-center justify-content-center" style="height: 85px;">
                                            @if ($related->image)
                                                <img src="{{ asset('storage/' . $related->image) }}" class="w-100 h-100" alt="{{ $related->name }}" style="object-fit: cover;">
                                            @else
                                                <i class="fa-solid fa-image text-white-50"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Related Product Info -->
                                    <div class="col-8">
                                        <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 14px;" title="{{ $related->name }}">
                                            {{ $related->name }}
                                        </h6>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="text-success fw-bold" style="font-size: 14px;">
                                                ${{ number_format($related->price, 2) }}
                                            </span>
                                            <a href="{{ route('shop.show', $related) }}" class="btn btn-outline-dark btn-sm px-3 py-1" style="font-size: 12px;">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4 small">
                                No related watches found in this category.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Custom CSS for Hover Effect -->
    <style>
        .related-card {
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }
        .related-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.08) !important;
            border-color: #ffc107 !important;
            background-color: #fafafa;
        }
    </style>

    <!-- SweetAlert2 & AJAX Add to Cart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function incrementQty(maxStock) {
            let qtyInput = document.getElementById('product-quantity');
            let currentVal = parseInt(qtyInput.value);

            if (currentVal < maxStock) {
                qtyInput.value = currentVal + 1;
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: 'Cannot exceed available stock (' + maxStock + ' units left)!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }

        function decrementQty() {
            let qtyInput = document.getElementById('product-quantity');
            let currentVal = parseInt(qtyInput.value);
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        }

        // --- AJAX Add to Cart Logic ---
        document.addEventListener('DOMContentLoaded', function () {
            const addToCartBtn = document.querySelector('.btn-success.w-100'); // Add to Cart button

            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function () {
                    const productId = "{{ $product->id }}";
                    const quantity = document.getElementById('product-quantity').value;

                    addToCartBtn.disabled = true;
                    addToCartBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-2"></i> Adding...`;

                    fetch("{{ route('cart.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = `<i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart`;

                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            });

                            const cartCountBadge = document.getElementById('cart-count');
                            if (cartCountBadge) {
                                cartCountBadge.innerText = data.cartCount;
                            }
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: data.message || 'Something went wrong!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = `<i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart`;

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'An error occurred. Please try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    });
                });
            }
        });
    </script>
@endsection
