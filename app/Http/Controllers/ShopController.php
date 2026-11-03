<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // dd(Auth::user()->role);

        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $products = Product::all();
        return view('shop.index', compact('products'));
    }
}
