@extends('layouts.shop')

@section('title', 'Shopping Cart - Ruiz Watches')

@section('content')
    <div class="container py-5" style="font-family: 'Domine', serif; margin-top: 60px;">

        <!-- Page Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0" style="font-family: 'Crimson Text', serif;">
                <i class="fa-solid fa-cart-shopping me-2 text-warning"></i> Your Shopping Cart
            </h2>
            <a href="{{ route('shop.index') }}#back-to-collection" class="text-decoration-none text-dark fw-semibold small">
                <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping
            </a>
        </div>

        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}

        @php
            $cart = session('cart', []);
        @endphp

        @if (count($cart) > 0)
            <div class="row g-4">
                <!-- Cart Items Table (col-lg-8) -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light text-uppercase fs-7">
                                    <tr>
                                        <th class="py-3">Product</th>
                                        <th class="py-3">Price</th>
                                        <th class="py-3" style="width: 150px;">Quantity</th>
                                        <th class="py-3">Subtotal</th>
                                        <th class="py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @foreach ($cart as $id => $item)
                                        @php
                                            $subtotal = $item['price'] * $item['quantity'];
                                            $grandTotal += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-black rounded-3 overflow-hidden d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        @if (isset($item['image']))
                                                            <img src="{{ asset('storage/' . $item['image']) }}"
                                                                alt="{{ $item['name'] }}" class="w-100 h-100"
                                                                style="object-fit: cover;">
                                                        @else
                                                            <i class="fa-solid fa-image text-white-50"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">
                                                            {{ $item['name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-semibold text-secondary" style="font-size: 14px;">
                                                ${{ number_format($item['price'], 2) }}
                                            </td>
                                            <td>
                                                <!-- Quantity Update Form -->
                                                <form action="{{ route('cart.update', $id) }}" method="POST"
                                                    class="d-flex align-items-center cart-update-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <!-- Quantity Update Input -->
                                                    <input type="number" value="{{ $item['quantity'] }}" min="1"
                                                        class="form-control form-control-sm text-center fw-bold me-2 cart-qty-input"
                                                        style="width: 70px;" data-id="{{ $id }}">
                                                </form>
                                            </td>
                                            <td class="fw-bold text-success item-subtotal" style="font-size: 14px;">
                                                ${{ number_format($subtotal, 2) }}
                                            </td>
                                            <td class="text-center">
                                                <!-- Remove Button -->
                                                <form action="{{ route('cart.destroy', $id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1"
                                                        title="Remove">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary (col-lg-4) -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h4 class="fw-bold text-dark mb-3" style="font-family: 'Crimson Text', serif; font-size: 20px;">
                            Order Summary
                        </h4>

                        <!-- Total Items -->
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <span>Total Items</span>
                            <span class="fw-bold text-dark" id="total-items-count">{{ collect($cart)->sum('quantity') }}
                                units</span>
                        </div>

                        <!-- Order Summary Subtotal -->
                        <div class="d-flex justify-content-between mb-3 text-muted small">
                            <span>Subtotal</span>
                            <span class="fw-bold text-dark"
                                id="summary-subtotal">${{ number_format($grandTotal, 2) }}</span>
                        </div>

                        <hr class="text-muted my-3">

                        <!-- Grand Total -->
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold text-dark fs-5">Grand Total</span>
                            <span class="fw-bold text-success fs-5"
                                id="grand-total-amount">${{ number_format($grandTotal, 2) }}</span>
                        </div>

                        @auth
                            <a href="{{ route('checkout.index') }}"
                                class="btn btn-success btn-md rounded-pill fw-semibold text-white w-100 py-2 shadow-sm border-0">
                                Proceed to Checkout <i class="fa-solid fa-arrow-right ms-2"></i>
                            </a>
                        @endauth

                        @guest
                            <button type="button" data-bs-toggle="modal" data-bs-target="#loginModal"
                                class="btn btn-success btn-md rounded-pill fw-semibold text-white w-100 py-2 shadow-sm border-0">
                                Proceed to Checkout <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        @endguest
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart State -->
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border-0 p-5">
                <i class="fa-solid fa-cart-shopping fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                <h4 class="fw-bold text-dark mb-2">Your cart is currently empty</h4>
                <p class="text-muted mb-4 small">Looks like you haven't added any watches to your cart yet.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold">
                    Start Shopping
                </a>
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const qtyInputs = document.querySelectorAll('.cart-qty-input');

            qtyInputs.forEach(input => {
                input.addEventListener('change', function() {
                    let productId = this.getAttribute('data-id');
                    let quantity = this.value;
                    let inputElement = this;

                    fetch(`/cart/${productId}`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "X-Requested-With": "XMLHttpRequest",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                _method: "PATCH",
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cart Updated',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1000,
                                    toast: true,
                                    position: 'top-end'
                                });

                                let row = inputElement.closest('tr');
                                let subtotalCell = row.querySelector('.item-subtotal');
                                subtotalCell.innerText = '$' + data.itemSubtotal.toFixed(2);

                                document.getElementById('grand-total-amount').innerText = '$' +
                                    data.grandTotal.toFixed(2);
                                document.getElementById('total-items-count').innerText = data
                                    .totalItems + ' units';

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Stock Limit Exceeded',
                                    text: data.message,
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#343a40',
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
@endsection
