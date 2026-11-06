@extends('layouts.shop')

@section('title', 'Checkout - Ruiz Watches')

@section('content')
    <div class="container py-5" style="margin-top: 60px;">

        <!-- Page Title -->
        <div class="mb-4">
            <h2 class="fw-bold text-dark mb-0" style="font-family: 'Crimson Text', serif;">
                <i class="fa-solid fa-credit-card me-2 text-success"></i> Checkout & Payment
            </h2>
            <p class="text-muted small">Please choose your payment method and upload the transfer screenshot.</p>
        </div>

        @php
            $cart = session('cart', []);
        @endphp

        @if (count($cart) > 0)
            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">

                    <!-- ဘယ်ဘက်ခြမ်း: Payment Methods Cards -->
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3 text-dark" style="font-size: 18px;">
                            <i class="fa-solid fa-wallet text-success me-2"></i> Payment Methods
                        </h4>

                        @foreach ($paymentMethods as $method)
                            <div class="card border-0 shadow-sm rounded-4 p-3 mb-3 bg-white border-start border-success border-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-primary mb-2">{{ $method->name }}</span>
                                        <h6 class="text-muted small mb-1">ACCOUNT NAME</h6>
                                        <h5 class="fw-bold text-dark mb-2">{{ $method->account_name }}</h5>
                                        <h6 class="text-muted small mb-1">ACCOUNT NUMBER</h6>
                                        <h5 class="fw-bold text-success mb-0">{{ $method->account_number }}</h5>
                                    </div>
                                    <i class="fa-solid fa-building-columns fs-1 text-secondary opacity-25"></i>
                                </div>
                            </div>
                        @endforeach

                        <!-- Info Alert -->
                        <div class="alert alert-warning border-0 shadow-sm rounded-3 small mt-3" style="background-color: #fff9e6;">
                            <i class="fa-solid fa-circle-info text-warning me-1"></i> ငွေလွှဲပြီးပါက ညာဘက်ရှိ Form တွင် ငွေလွှဲပြေစာ (Screenshot) တင်ပေးပါ။
                        </div>
                    </div>

                    <!-- ညာဘက်ခြမ်း: Payment Submission Form -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                            <h4 class="fw-bold mb-3 text-dark" style="font-size: 18px;">Payment Submission</h4>

                            <!-- User Name (Readonly) -->
                            <div class="mb-3">
                                <label class="form-label small text-muted">User Name</label>
                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->name ?? '' }}" readonly>
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label class="form-label small text-muted">Phone Number</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label small text-muted">Address</label>
                                <textarea name="shipping_address" rows="3" class="form-control @error('shipping_address') is-invalid @enderror"
                                    placeholder="Enter your delivery address..." required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select Payment Method -->
                            {{-- <div class="mb-3">
                                <label class="form-label small text-muted">Payment Method</label>
                                <select name="payment_method_id" class="form-select @error('payment_method_id') is-invalid @enderror" >
                                    <option value="">Select Payment Method</option>
                                    @foreach ($paymentMethods as $method)
                                        <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }} ({{ $method->account_number }})
                                        </option>
                                    @endforeach
                                </select>
                                {{-- @error('payment_method_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                            </div> --}}

                            <!-- Payslip Image -->
                            <div class="mb-3">
                                <label class="form-label small text-muted">Payslip Image</label>
                                <input type="file" name="payment_slip" class="form-control @error('payment_slip') is-invalid @enderror" required>
                                @error('payment_slip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Total Amount Box -->
                            @php
                                $grandTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
                            @endphp
                            <div class="p-3 bg-light rounded-3 mb-4 d-flex justify-content-between align-items-center border">
                                <div>
                                    <span class="text-muted small d-block" style="font-size: 11px; font-weight: bold;">TOTAL AMOUNT</span>
                                    <h4 class="fw-bold text-success mb-0">${{ number_format($grandTotal, 2) }}</h4>
                                </div>
                                <span class="badge bg-white text-dark border px-3 py-2">Cart Total</span>
                            </div>

                            <!-- Confirm Order Button -->
                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold rounded-pill shadow-sm">
                                <i class="fa-solid fa-check-circle me-2"></i> CONFIRM ORDER
                            </button>

                            <div class="text-center mt-3">
                                <a href="{{ route('cart.index') }}" class="text-decoration-none text-muted small">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Cart
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        @else
            <!-- Empty Cart State -->
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border-0 p-5">
                <i class="fa-solid fa-cart-shopping fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                <h4 class="fw-bold text-dark mb-2">Your cart is empty</h4>
                <p class="text-muted mb-4 small">You need to add items to your cart before checking out.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold">
                    Go to Shop
                </a>
            </div>
        @endif

    </div>
@endsection
