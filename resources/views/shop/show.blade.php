@extends('layouts.shop')

@section('title', $product->name . ' - Ruiz Watches')

@section('content')
    <div class="container py-5" style="font-family: 'Domine', serif; margin-top: 60px;">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('shop.index') }}#back-to-collection" class="text-decoration-none text-dark fw-semibold"
                style="font-size: 14px;">
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
                            <div class="bg-black rounded-4 overflow-hidden d-flex align-items-center justify-content-center position-relative shadow-sm"
                                style="height: 380px;">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100"
                                        alt="{{ $product->name }}" style="object-fit: cover;">
                                @else
                                    <div class="text-white-50 text-center">
                                        <i class="fa-solid fa-image fa-3x mb-2"></i>
                                        <div class="small">No Image Available</div>
                                    </div>
                                @endif

                                <!-- Category & Gender Badges -->
                                <div class="position-absolute top-0 start-0 m-3 d-flex flex-column gap-1 z-index-1">
                                    <span class="badge bg-success text-white px-2 py-1"
                                        style="font-size: 11px; border-radius: 4px;">
                                        {{ $product->category->name ?? 'Watch' }}
                                    </span>

                                    @if ($product->gender == 'men')
                                        <span class="badge bg-primary text-white px-2 py-1"
                                            style="font-size: 11px; border-radius: 4px;">Men</span>
                                    @elseif($product->gender == 'women')
                                        <span class="badge bg-danger text-white px-2 py-1"
                                            style="font-size: 11px; border-radius: 4px;">Women</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-2 py-1"
                                            style="font-size: 11px; border-radius: 4px;">Unisex</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Product Info Column -->
                        <div class="col-md-6 text-start d-flex flex-column justify-content-between"
                            style="min-height: 380px;">
                            <div>
                                <h2 class="fw-bold text-dark mb-2"
                                    style="font-family: 'Crimson Text', serif; font-size: 26px;">
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
                                        <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 11px;">Low
                                            Stock ({{ $stock }} left)</span>
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
                                <p class="text-muted mb-4"
                                    style="font-family: 'Albert Sans', sans-serif; line-height: 1.7; font-size: 14px;">
                                    {{ $product->description ?? 'No detailed description available for this watch.' }}
                                </p>
                            </div>

                            <!-- Bottom Action Section -->
                            <div class="mt-auto">
                                @if ($stock > 0)
                                    <div class="mb-3 d-flex align-items-center justify-content-between gap-3">
                                        <!-- Quantity Selector -->
                                        <div>
                                            <label class="form-label fw-bold text-dark small mb-1"
                                                style="font-size: 12px;">Quantity:</label>
                                            <div class="input-group input-group-sm" style="width: 130px;">
                                                <button class="btn btn-outline-danger px-3 py-1 fw-bold" type="button"
                                                    onclick="decrementQty()">-</button>
                                                <input type="text" id="product-quantity"
                                                    class="form-control text-center fw-bold bg-white px-1" value="1"
                                                    readonly style="font-size: 14px;">
                                                <button class="btn btn-outline-success px-3 py-1 fw-bold" type="button"
                                                    onclick="incrementQty({{ $stock }})">+</button>
                                            </div>
                                        </div>

                                        <!-- Rating Button / Display -->
                                        <div>
                                            @php
                                                $avgRating = $product->ratings()->avg('rating') ?? 0;
                                                $ratingCount = $product->ratings()->count();
                                                $userRatingRecord = auth()->check()
                                                    ? $product->ratings()->where('user_id', auth()->id())->first()
                                                    : null;
                                                $userRatingVal = $userRatingRecord ? $userRatingRecord->rating : 0;
                                            @endphp

                                            @auth
                                                <label class="form-label fw-bold text-dark small mb-1 d-block text-end"
                                                    style="font-size: 12px;">Rating</label>
                                                <button type="button"
                                                    class="btn btn-link p-0 text-decoration-none border-0 bg-transparent d-flex align-items-center gap-2"
                                                    data-bs-toggle="modal" data-bs-target="#ratingModal">
                                                    <div class="text-warning" style="font-size: 15px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= round($avgRating))
                                                                <i class="fa-solid fa-star"></i>
                                                            @else
                                                                <i class="fa-regular fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="fw-bold text-dark"
                                                        style="font-size: 15px;">{{ number_format($avgRating, 1) }}</span>
                                                    <span class="text-muted small"
                                                        style="font-size: 12px;">({{ $ratingCount }})</span>
                                                </button>
                                            @else
                                                <label class="form-label fw-bold text-dark small mb-1 d-block text-end"
                                                    style="font-size: 12px;">Rating:</label>
                                                <div class="d-flex align-items-center justify-content-end gap-2">
                                                    <div class="text-warning" style="font-size: 15px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= round($avgRating))
                                                                <i class="fa-solid fa-star"></i>
                                                            @else
                                                                <i class="fa-regular fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="fw-bold text-dark"
                                                        style="font-size: 15px;">{{ number_format($avgRating, 1) }}</span>
                                                    <span class="text-muted small"
                                                        style="font-size: 12px;">({{ $ratingCount }})</span>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                @endif

                                <!-- Add to Cart Button -->
                                <div>
                                    @if ($stock > 0)
                                        <button
                                            class="btn btn-success btn-md rounded-pill fw-semibold text-white w-100 shadow-sm py-2"
                                            style="font-size: 14px;">
                                            <i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-secondary btn-md rounded-pill fw-semibold text-white w-100 shadow-sm py-2"
                                            style="font-size: 14px;" disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Comments Section Added Inside Main Card Bottom -->
                    <div class="mt-5 pt-4 border-top">
                        <h5 class="fw-bold text-dark mb-3" style="font-family: 'Crimson Text', serif; font-size: 18px;">
                            <i class="fa-solid fa-comments me-2 text-warning"></i> Comments
                            <span class="text-muted fw-normal fs-6">({{ $product->comments->count() }})</span>
                        </h5>

                        <!-- Comment Form / Login Prompt -->
                        @auth
                            <form action="{{ route('comments.store', $product->id) }}" method="POST">
                                @csrf
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-grow-1">
                                        <textarea name="comment" rows="1" class="form-control form-control-sm"
                                            placeholder="Write your comment here..." style="font-size: 13px;" required></textarea>
                                    </div>

                                    <!-- Button -->
                                    <div>
                                        <button type="submit"
                                            class="btn btn-dark btn-sm rounded-pill px-3 fw-semibold text-nowrap"
                                            style="font-size: 12px;">
                                            <i class="fa-solid fa-paper-plane me-1"></i> Post
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-2 bg-light rounded-3 border" style="font-size: 13px;">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"
                                    class="text-decoration-none fw-semibold text-primary">Login</a> to comment.
                            </div>
                        @endauth

                        <!-- Comments List -->
                        <div class="comments-container mb-3 px-2" style="max-height: 300px; overflow-y: auto;">
                            @forelse ($product->comments()->where('is_approved', 1)->latest()->get() as $item)
                                <div class="py-3 border-bottom" id="comment-box-{{ $item->id }}">
                                    <!-- Header: Profile, Name & Time -->
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-circle-user text-secondary"
                                                style="font-size: 20px;"></i>
                                            <span class="fw-bold text-dark"
                                                style="font-size: 13px;">{{ $item->user->name ?? 'Anonymous' }}</span>
                                        </div>
                                        <span class="text-muted"
                                            style="font-size: 11px;">{{ $item->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- Comment Text -->
                                    <p class="text-secondary ms-4 ps-1 mb-2 comment-text-{{ $item->id }}"
                                        style="font-size: 13px; font-family: 'Albert Sans', sans-serif;">
                                        {{ $item->comment }}
                                    </p>

                                    <!-- Edit Form (Initially Hidden) -->
                                    <div id="edit-form-{{ $item->id }}" class="d-none ms-4 mb-2">
                                        <form action="{{ route('comments.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <textarea name="comment" rows="2" class="form-control form-control-sm" style="font-size: 13px;" required>{{ $item->comment }}</textarea>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-dark btn-sm px-3"
                                                    style="font-size: 11px;">Update</button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm px-3"
                                                    style="font-size: 11px;"
                                                    onclick="toggleEdit({{ $item->id }})">Cancel</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Action Icons (Edit & Delete) -->
                                    @auth
                                        @if (Auth::id() === $item->user_id || (isset(Auth::user()->role) && Auth::user()->role === 'admin'))
                                            <div class="text-end ms-4 d-flex justify-content-end align-items-center gap-3">
                                                <!-- Edit Icon -->
                                                <i class="fa-solid fa-pen-to-square text-primary"
                                                    style="font-size: 14px; cursor: pointer;" title="Edit"
                                                    onclick="toggleEdit({{ $item->id }})"></i>

                                                <!-- Delete Icon -->
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('comments.destroy', $item->id) }}" method="POST"
                                                    class="d-inline m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn p-0 border-0 bg-transparent text-danger"
                                                        style="font-size: 14px;" title="Delete"
                                                        onclick="confirmDelete({{ $item->id }})">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            @empty
                                <p class="text-muted small text-center py-3">No comments yet. Be the first to comment!</p>
                            @endforelse
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
                                                class="btn btn-outline-dark btn-sm px-3 py-1" style="font-size: 12px;">
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

    <!-- Rating Modal Box -->
    @auth
        <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="font-family: 'Domine', serif;">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold text-dark" id="ratingModalLabel">Rate {{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <p class="text-muted small mb-3">Please click a star to submit your rating:</p>

                        <form action="{{ route('products.rate', $product->id) }}" method="POST" id="rating-form">
                            @csrf
                            <div class="star-rating-modal justify-content-center mb-3">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating"
                                        value="{{ $i }}"
                                        onchange="document.getElementById('rating-form').submit()"
                                        {{ $userRatingVal == $i ? 'checked' : '' }} />
                                    <label for="star{{ $i }}" title="{{ $i }} stars">
                                        <i class="fa-solid fa-star fs-2 mx-1"></i>
                                    </label>
                                @endfor
                            </div>
                        </form>

                        <div class="text-muted small mt-2" style="font-size: 11px;">Rating will be saved instantly upon
                            selection.</div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <!-- Custom CSS for Hover Effect & Star Rating -->
    <style>
        .related-card {
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .related-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08) !important;
            border-color: #ffc107 !important;
            background-color: #fafafa;
        }

        .star-rating-modal {
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 6px;
        }

        .star-rating-modal input {
            display: none;
        }

        .star-rating-modal label {
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating-modal input:checked~label,
        .star-rating-modal label:hover,
        .star-rating-modal label:hover~label {
            color: #ffc107;
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
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartBtn = document.querySelector('.btn-success.w-100');

            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
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
                            addToCartBtn.innerHTML =
                                `<i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart`;

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
                            addToCartBtn.innerHTML =
                                `<i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart`;

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

        function toggleEdit(id) {
            const commentText = document.querySelector('.comment-text-' + id);
            const editForm = document.getElementById('edit-form-' + id);

            if (editForm.classList.contains('d-none')) {
                editForm.classList.remove('d-none');
                commentText.classList.add('d-none');
            } else {
                editForm.classList.add('d-none');
                commentText.classList.remove('d-none');
            }
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form-' + id);
                    if (form) {
                        form.submit();
                    } else {
                        console.error('Delete form not found for ID: ' + id);
                    }
                }
            });

            function submitRatingForm(ratingVal) {
                const radioBtn = document.getElementById('star' + ratingVal);
                if (radioBtn) {
                    radioBtn.checked = true;
                    document.getElementById('rating-form').submit();
                }
            }
        }
    </script>
@endsection
