@extends('layouts.shop')

@section('title', $product->name . ' - Ruiz Watches')

@section('content')
    <div class="container py-5" style="font-family: 'Domine', serif; margin-top: 60px;">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('shop.index') }}" class="text-decoration-none text-dark fw-semibold" style="font-size: 14px;">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to Collection
            </a>
        </div>

        <div class="row g-4 align-items-start">

            <!-- Main Product Details (col-lg-8) -->
            <div class="col-lg-8">
                <div class="bg-white p-4 border shadow-sm rounded-4 h-100">
                    <div class="row g-4 align-items-center">
                        <!-- Product Image Column -->
                        <div class="col-md-5">
                            <div class="bg-black rounded-3 overflow-hidden d-flex align-items-center justify-content-center position-relative"
                                style="height: 500px;">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100"
                                        alt="{{ $product->name }}" style="object-fit: cover;">
                                @else
                                    <div class="text-white-50 text-center">
                                        <i class="fa-solid fa-image fa-2x mb-1"></i>
                                        <div class="small">No Image</div>
                                    </div>
                                @endif

                                <!-- Category & Gender Badges -->
                                <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1">
                                    <span class="badge bg-success text-white px-2 py-1"
                                        style="font-size: 10px; border-radius: 4px;">
                                        {{ $product->category->name ?? 'Watch' }}
                                    </span>

                                    @if ($product->gender == 'men')
                                        <span class="badge bg-primary text-white px-2 py-1"
                                            style="font-size: 10px; border-radius: 4px;">Men</span>
                                    @elseif($product->gender == 'women')
                                        <span class="badge bg-danger text-white px-2 py-1"
                                            style="font-size: 10px; border-radius: 4px;">Women</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-2 py-1"
                                            style="font-size: 10px; border-radius: 4px;">Unisex</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Product Info Column -->
                        <div class="col-md-7 text-start">
                            <h2 class="fw-bold text-dark mb-2" style="font-family: 'Crimson Text', serif; font-size: 24px;">
                                {{ $product->name }}
                            </h2>

                            <!-- Stock Status & Total Stock Count -->
                            @php
                                $stock = $product->inventory->stock_quantity ?? 0;
                            @endphp
                            <div class="mb-2 d-flex align-items-center flex-wrap gap-2">
                                @if ($stock == 0)
                                    <span class="badge bg-danger px-2 py-1" style="font-size: 11px;">Out of Stock</span>
                                @elseif ($stock < 3)
                                    <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 11px;">Low
                                        ({{ $stock }} left)</span>
                                @else
                                    <span class="badge bg-secondary px-2 py-1" style="font-size: 11px;">In Stock</span>
                                @endif

                                <span class="text-muted small" style="font-size: 12px;">
                                    (Stock: <span class="text-dark fw-bold">{{ $stock }}</span>)
                                </span>
                            </div>

                            <!-- Price -->
                            <h3 class="text-success fw-bold mb-3" style="font-size: 22px;">
                                ${{ number_format($product->price, 2) }}
                            </h3>

                            <hr class="text-muted my-2">

                            <!-- Description -->
                            <p class="text-muted mb-3"
                                style="font-family: 'Albert Sans', sans-serif; line-height: 1.6; font-size: 14px;">
                                {{ $product->description }}
                            </p>

                            <!-- Quantity Selector -->
                            @if ($stock > 0)
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark small mb-1"
                                        style="font-size: 12px;">Quantity:</label>
                                    <div class="input-group input-group-sm" style="width: 120px;">
                                        <button class="btn btn-outline-danger px-2 py-1" type="button"
                                            onclick="decrementQty()">-</button>
                                        <input type="text" id="product-quantity"
                                            class="form-control text-center fw-bold bg-white px-1" value="1" readonly
                                            style="font-size: 13px;">
                                        <button class="btn btn-outline-success px-2 py-1" type="button"
                                            onclick="incrementQty({{ $stock }})">+</button>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex align-items-center gap-2">
                                @guest
                                    <button type="button" onclick="showRegisterAlert('{{ route('register') }}')"
                                        class="btn btn-success btn-sm rounded-pill fw-semibold text-white w-100 shadow-sm border-0 py-2"
                                        style="font-size: 13px;">
                                        Buy Now
                                    </button>
                                @endguest

                                @auth
                                    @if ($stock > 0)
                                        <button
                                            class="btn btn-success btn-sm rounded-pill fw-semibold text-white w-100 shadow-sm py-2"
                                            style="font-size: 13px;">
                                            <i class="fa-solid fa-cart-shopping me-1"></i> Add to Cart
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-secondary btn-sm rounded-pill fw-semibold text-white w-100 shadow-sm py-2"
                                            style="font-size: 13px;" disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Watches (col-lg-4) -->
            <div class="col-lg-4">
                <div class="bg-white p-3 border shadow-sm rounded-4">
                    <h5 class="fw-bold text-dark mb-3" style="font-family: 'Crimson Text', serif; font-size: 17px;">
                        <i class="fa-solid fa-clock me-1 text-warning"></i> Related Watches
                    </h5>

                    <div class="d-flex flex-column gap-2">
                        @forelse($relatedProducts as $related)
                            @php
                                $relStock = $related->inventory->stock_quantity ?? 0;
                            @endphp
                            <div class="card border rounded-3 p-3 shadow-none related-card" style="min-height: 105px;">
                                <div class="row g-2 align-items-center h-100">
                                    <!-- Related Product Image -->
                                    <div class="col-4">
                                        <div class="bg-black rounded-2 overflow-hidden d-flex align-items-center justify-content-center"
                                            style="height: 85px;">
                                            @if ($related->image)
                                                <img src="{{ asset('storage/' . $related->image) }}" class="w-100 h-100"
                                                    alt="{{ $related->name }}" style="object-fit: cover;">
                                            @else
                                                <i class="fa-solid fa-image text-white-50"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Related Product Info -->
                                    <div class="col-8">
                                        <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 14px;"
                                            title="{{ $related->name }}">
                                            {{ $related->name }}
                                        </h6>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="text-success fw-bold" style="font-size: 14px;">
                                                ${{ number_format($related->price, 2) }}
                                            </span>
                                            <a href="{{ route('shop.show', $related) }}"
                                                class="btn btn-outline-success btn-sm px-3 py-1" style="font-size: 12px;">
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

    <!-- SweetAlert2 & Quantity Logic Scripts -->
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
                    title: 'Cannot exceed available stock!',
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
