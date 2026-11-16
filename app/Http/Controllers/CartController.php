<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartSubtotal = 0;
        foreach ($cart as $item) {
            $cartSubtotal += $item['price'] * $item['quantity'];
        }

        $allCoupons = Coupon::whereNull('expires_at')
            ->orWhere('expires_at', '>', now())
            ->get();

        $discountAmount = 0;
        if (session()->has('coupon')) {
            $appliedData = session('coupon');
            $appliedCoupon = Coupon::where('code', $appliedData['code'])->first();

            if (!$appliedCoupon || ($appliedCoupon->min_spend && $cartSubtotal < $appliedCoupon->min_spend)) {
                session()->forget('coupon');
            } else {
                $couponType = strtolower(trim($appliedCoupon->type));
                if ($couponType === 'percent') {
                    $discountAmount = ($cartSubtotal * $appliedCoupon->value) / 100;
                } else {
                    $discountAmount = (float) $appliedCoupon->value;
                }
            }
        }

        $grandTotal = max(0, $cartSubtotal - $discountAmount);

        return view('cart.index', compact('cart', 'cartSubtotal', 'allCoupons', 'discountAmount', 'grandTotal'));
    }

    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $product = Product::findOrFail($productId);
        $availableStock = $product->inventory->stock_quantity ?? 0;

        $cart = session()->get('cart', []);
        $currentCartQuantity = isset($cart[$productId]) ? (int) $cart[$productId]['quantity'] : 0;

        if (($currentCartQuantity + $quantity) > $availableStock) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available!',
                ], 422);
            }
            return redirect()->back()->with('error', 'Insufficient stock available.');
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = (int) $cart[$productId]['quantity'] + $quantity;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image,
                "slug" => $product->slug
            ];
        }

        session()->put('cart', $cart);

        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += (int) $item['quantity'];
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $requestedQuantity = (int) $request->input('quantity', 1);

            $product = Product::find($id);
            $availableStock = $product ? ($product->inventory->stock_quantity ?? 0) : 0;

            if ($requestedQuantity > $availableStock) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock available! (Available: ' . $availableStock . ' units)'
                    ]);
                }
                return redirect()->back()->with('error', 'Insufficient stock available.');
            }

            $cart[$id]['quantity'] = $requestedQuantity;
            session()->put('cart', $cart);

            $cartSubtotal = 0;
            $totalItems = 0;
            foreach ($cart as $item) {
                $cartSubtotal += $item['price'] * $item['quantity'];
                $totalItems += $item['quantity'];
            }

            $discountAmount = 0;
            if (session()->has('coupon')) {
                $appliedData = session('coupon');
                $appliedCoupon = Coupon::where('code', $appliedData['code'])->first();

                if ($appliedCoupon) {
                    if ($appliedCoupon->min_spend && $cartSubtotal < $appliedCoupon->min_spend) {
                        session()->forget('coupon');
                    } else {
                        $couponType = strtolower(trim($appliedCoupon->type));
                        if ($couponType === 'percent') {
                            $discountAmount = ($cartSubtotal * $appliedCoupon->value) / 100;
                        } else {
                            $discountAmount = (float) $appliedCoupon->value;
                        }
                    }
                }
            }

            $grandTotal = max(0, $cartSubtotal - $discountAmount);
            $itemSubtotal = $cart[$id]['price'] * $cart[$id]['quantity'];

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'itemSubtotal' => $itemSubtotal,
                    'cartSubtotal' => $cartSubtotal,
                    'discountAmount' => $discountAmount,
                    'grandTotal' => $grandTotal,
                    'totalItems' => $totalItems
                ]);
            }
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function destroy(string $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:coupons,code',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if ($coupon->expires_at && Carbon::now()->greaterThan($coupon->expires_at)) {
            return back()->with('error', 'This coupon has expired.');
        }

        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        if ($coupon->min_spend && $subtotal < $coupon->min_spend) {
            return back()->with('error', 'Minimum spend of $' . number_format($coupon->min_spend, 2) . ' is required.');
        }

        if (strtolower(trim($coupon->type)) === 'fixed' && $coupon->value > $subtotal) {
            return back()->with('error', 'This coupon value exceeds your cart subtotal.');
        }

        session(['coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => strtolower(trim($coupon->type)),
            'value' => (float) $coupon->value,
        ]]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }
}
