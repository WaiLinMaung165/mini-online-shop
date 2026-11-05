<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'totalPrice'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

        // Cart Count ပြန်တွက်ရန်
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

            $grandTotal = 0;
            $totalItems = 0;
            foreach ($cart as $item) {
                $grandTotal += $item['price'] * $item['quantity'];
                $totalItems += $item['quantity'];
            }

            $itemSubtotal = $cart[$id]['price'] * $cart[$id]['quantity'];

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'itemSubtotal' => $itemSubtotal,
                    'grandTotal' => $grandTotal,
                    'totalItems' => $totalItems
                ]);
            }
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart.');
    }
}
