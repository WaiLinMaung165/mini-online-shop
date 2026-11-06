<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function index()
    {

        $cart = session('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('checkout.index', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method_id' => 'exists:payment_methods,id',
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cart = session('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $slipPath = null;
        if ($request->hasFile('payment_slip')) {
            $slipPath = $request->file('payment_slip')->store('slips', 'public');
        }

        Order::create([
            'user_id' => Auth::id(),
            // 'payment_method_id' => $request->payment_method_id,
            'order_code' => '#MOS_POS_' . rand(1000000000, 9999999999),
            'total_amount' => $totalAmount,
            'phone' => $request->phone,
            'shipping_address' => $request->shipping_address,
            'payment_slip' => $slipPath,
            'status' => 'Pending',
        ]);

        session()->forget('cart');

        return redirect()->route('shop.index')->with('success', 'Order placed successfully! Please wait for confirmation.');
    }
}
