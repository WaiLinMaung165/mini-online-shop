<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with(['category', 'inventory']);

    // Category Filter
    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }

    // Gender Filter (men, women, unisex)
    if ($request->has('gender') && $request->gender != '') {
        $query->where('gender', $request->gender);
    }

    $products = $query->latest()->get();

    if ($request->ajax()){
        return view('shop.partials.products', compact('products'))->render();
    }

    return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'inventory']);

        $relatedProducts = Product::with(['category', 'inventory'])
            ->where('category_id', $product->category_id)
            ->where('gender', $product->gender)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
