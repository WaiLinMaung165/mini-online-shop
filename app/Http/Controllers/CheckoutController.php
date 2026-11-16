<?php

namespace App\Http\Controllers;

use App\Mail\AdminNewOrderMail;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        $cartSubtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $discountAmount = 0;
        $appliedCouponCode = null;

        if (session()->has('coupon')) {
            $appliedData = session('coupon');
            $appliedCoupon = Coupon::where('code', $appliedData['code'])->first();

            if ($appliedCoupon) {
                if ($appliedCoupon->min_spend && $cartSubtotal < $appliedCoupon->min_spend) {
                    session()->forget('coupon');
                } else {
                    $appliedCouponCode = $appliedCoupon->code;
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

        return view('checkout.index', compact('paymentMethods', 'cartSubtotal', 'discountAmount', 'appliedCouponCode', 'grandTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_slip' => 'required|image|mimes:jpeg,webp,png,jpg|max:2048',
        ]);

        $cart = session('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $cartSubtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $discountAmount = 0;
        $appliedCouponCode = null;

        if (session()->has('coupon')) {
            $appliedData = session('coupon');
            $appliedCoupon = Coupon::where('code', $appliedData['code'])->first();
            if ($appliedCoupon && (!$appliedCoupon->min_spend || $cartSubtotal >= $appliedCoupon->min_spend)) {
                $appliedCouponCode = $appliedCoupon->code;
                $couponType = strtolower(trim($appliedCoupon->type));
                if ($couponType === 'percent') {
                    $discountAmount = ($cartSubtotal * $appliedCoupon->value) / 100;
                } else {
                    $discountAmount = (float) $appliedCoupon->value;
                }
            }
        }

        $grandTotal = max(0, $cartSubtotal - $discountAmount);
        $order = DB::transaction(function () use ($request, $cart, $cartSubtotal, $discountAmount, $grandTotal, $appliedCouponCode) {

            $newOrder = Order::create([
                'user_id' => Auth::id(),
                'order_code' => '#MOS_POS_' . rand(1000000000, 9999999999),
                'total_amount' => $grandTotal,
                'phone' => $request->phone,
                'shipping_address' => $request->shipping_address,
                'status' => 'Pending',
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $inventory = Inventory::where('product_id', $productId)->first();
                if ($inventory) {
                    $inventory->decrement('stock_quantity', $item['quantity']);
                }
            }

            $slipPath = $request->file('payment_slip')->store('slips', 'public');

            Payment::create([
                'order_id' => $newOrder->id,
                'payment_method_id' => $request->payment_method_id,
                'payment_slip' => $slipPath,
                'amount' => $grandTotal,
                'status' => 'Pending',
            ]);

            return $newOrder;
        });

        session()->forget('cart');

        // To send email to admin
        $adminEmail = "ruizwatches51@gmail.com";
        try {
            Mail::to($adminEmail)->send(new AdminNewOrderMail($order));
        } catch (\Exception $e) {
            Log::error('Admin Order Email sending failed for order ' . $order->order_code . ': ' . $e->getMessage());
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully! Please wait for confirmation.');
    }
}
