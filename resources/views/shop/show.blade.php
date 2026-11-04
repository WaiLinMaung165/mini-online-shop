@extends('layouts.shop')

@section('title', $product->name . ' - Ruiz Watches')

@section('content')
    <div class="container py-5" style="font-family: 'Domine', serif; margin-top: 60px;">

        <!-- Back Button -->
        <div class="mb-4 mt-4">
            <a href="{{ route('shop.index') }}" class="text-decoration-none text-dark fw-semibold" style="font-size: 14px;">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to Collection
            </a>
        </div>

        <div class="row g-5 align-items-center bg-white p-4 border shadow-sm rounded-4">

            <!-- Product Image Column -->
            <div class="col-lg-5">
                <div class="bg-black rounded-4 overflow-hidden d-flex align-items-center justify-content-center position-relative" style="height: 500px;">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-100" alt="{{ $product->name }}" style="object-fit: cover; height: 500px;">
                    @else
                        <div class="text-white-50">
                            <i class="fa-solid fa-image fa-3x"></i>
                        </div>
                    @endif

                    <!-- Category Badge -->
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-success text-white px-3 py-2" style="font-size: 12px; border-radius: 6px;">
                            {{ $product->category->name ?? 'Watch' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Product Details Column -->
            <div class="col-lg-7 text-start">
                <h2 class="fw-bold text-dark mb-2" style="font-family: 'Crimson Text', serif;">
                    {{ $product->name }}
                </h2>

                <!-- Stock Status & Total Stock Count -->
                <div class="mb-3 d-flex align-items-center gap-2">
                    @if ($product->stock_quantity == 0)
                        <span class="badge bg-danger px-2 py-1">Out of Stock</span>
                    @elseif ($product->stock_quantity < 3)
                        <span class="badge bg-warning text-dark px-2 py-1">Low Stock ({{ $product->stock_quantity }} left)</span>
                    @else
                        <span class="badge bg-secondary px-2 py-1">In Stock</span>
                    @endif

                    <!-- Total Stock Quantity -->
                    <span class="text-muted small fw-semibold">
                        (Total Available Stock: <span class="text-dark fw-bold">{{ $product->stock_quantity }}</span> units)
                    </span>
                </div>

                <!-- Price -->
                <h3 class="text-success fw-bold mb-3">
                    ${{ number_format($product->price, 2) }}
                </h3>

                <hr class="text-muted">

                <!-- Description -->
                <h6 class="fw-bold text-dark mb-2">Description:</h6>
                <p class="text-muted mb-4" style="font-family: 'Albert Sans', sans-serif; line-height: 1.8; font-size: 15px;">
                    {{ $product->description }}
                </p>

                <!-- Quantity Increment / Decrement & Actions -->
                @if ($product->stock_quantity > 0)
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small">Quantity:</label>
                        <div class="input-group" style="width: 140px;">
                            <button class="btn btn-outline-danger px-3" type="button" onclick="decrementQty()">-</button>
                            <input type="text" id="product-quantity" class="form-control text-center fw-bold bg-white" value="1" readonly>
                            <button class="btn btn-outline-success px-3" type="button" onclick="incrementQty({{ $product->stock_quantity }})">+</button>
                        </div>
                    </div>
                @endif

                <!-- Actions / Buttons -->
                <div class="d-flex align-items-center gap-3">
                    @guest
                        <button type="button" onclick="showRegisterAlert('{{ route('register') }}')"
                            class="btn btn-success btn-lg rounded-pill fw-semibold text-white px-5 shadow-sm border-0">
                            Buy Now
                        </button>
                    @endguest

                    @auth
                        @if ($product->stock_quantity > 0)
                            <button class="btn btn-success btn-lg rounded-pill fw-semibold text-white px-5 shadow-sm">
                                <i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart
                            </button>
                        @else
                            <button class="btn btn-secondary btn-lg rounded-pill fw-semibold text-white px-5 shadow-sm" disabled>
                                Out of Stock
                            </button>
                        @endif
                    @endauth
                </div>

            </div>
        </div>

    </div>

    <!-- SweetAlert2 & Quantity Logic Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Quantity Increase Function
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
                    title: 'Cannot exceed available stock!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }

        // Quantity Decrease Function
        function decrementQty() {
            let qtyInput = document.getElementById('product-quantity');
            let currentVal = parseInt(qtyInput.value);
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        }

        // Guest Registration Alert
        function showRegisterAlert(registerUrl) {
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
