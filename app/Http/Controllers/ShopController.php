<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if (Auth::check()) {
            $products = $query->latest()->get();
        } else {
            $products = $query->latest()->take(10)->get();
        }

        return view('shop.index', compact('products', 'categories'));
    }
}
