<div class="product-grid-5" id="product-list-container">
    @forelse($products as $product)
        @php
            $stock = $product->inventory->stock_quantity ?? 0;
        @endphp
        <div class="product-item">
            <div class="card h-100 border shadow-sm rounded-4 overflow-hidden position-relative bg-white p-2">
                <div class="position-absolute top-0 start-0 m-2 z-index-1">
                    <span class="badge bg-success text-white px-2 py-1" style="font-size: 10px; border-radius: 4px;">
                        {{ $product->category->name ?? 'Watch' }}
                    </span>
                </div>

                <div class="position-absolute top-0 end-0 m-2 z-index-1">
                    @if ($stock == 0)
                        <span class="badge bg-danger p-1" style="font-size: 9px;">Out</span>
                    @elseif ($stock < 3)
                        <span class="badge bg-warning text-dark p-1" style="font-size: 9px;">Low</span>
                    @else
                        <span class="badge bg-secondary text-white p-1" style="font-size: 9px;">In Stock</span>
                    @endif
                </div>

                <div class="bg-black rounded-3 overflow-hidden d-flex align-items-center justify-content-center" style="height: 175px;">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100" alt="{{ $product->name }}" style="object-fit: cover;">
                    @else
                        <div class="text-white-50">
                            <i class="fa-solid fa-image fa-2x"></i>
                        </div>
                    @endif
                </div>

                <div class="card-body d-flex flex-column px-1 py-3 text-start">
                    <h6 class="card-title text-center fw-bold text-dark mb-1 text-truncate" style="font-size: 14px;" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h6>

                    <p class="text-muted mb-1" style="font-size: 13px; line-height: 1.5; overflow: hidden; margin-top: 5px; font-family: 'Albert Sans', sans-serif;">
                        {{ Str::limit($product->description, 50, '...') }}
                        <a href="{{ route('shop.show', $product) }}" class="text-primary text-decoration-none fw-semibold" style="font-size: 11px;">
                            See Details
                        </a>
                    </p>

                    <div class="d-flex align-items-center justify-content-between my-3">
                        <div class="text-dark fw-bold" style="font-size: 14px;">
                            ${{ number_format($product->price, 2) }}
                        </div>

                        <div class="input-group input-group-sm" style="width: 95px;">
                            <button class="btn btn-outline-danger px-2 py-0 fw-bold" type="button" onclick="decrementQty(this)" style="font-size: 15px; line-height: 1.5;">-</button>
                            <input type="text" class="form-control text-center px-1 py-0 bg-white fw-bold" value="1" readonly style="font-size: 13px;">
                            <button class="btn btn-outline-success px-2 py-0 fw-bold" type="button" onclick="incrementQty(this, {{ $stock }})" style="font-size: 15px; line-height: 1.5;">+</button>
                        </div>
                    </div>

                    <div class="mt-auto">
                        @if ($stock > 0)
                            <button class="btn btn-success btn-sm w-100 rounded-pill fw-semibold text-white shadow-sm" style="font-size: 12px; padding: 5px;">
                                <i class="fa-solid fa-cart-shopping me-1"></i> Add to Cart
                            </button>
                        @else
                            <button class="btn btn-secondary btn-sm w-100 rounded-pill fw-semibold text-white shadow-sm" style="font-size: 12px; padding: 5px;" disabled>
                                Out of Stock
                            </button>
                        @endif
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
