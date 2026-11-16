<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the wishlist products.
     */
    public function index()
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $userId = $user->id;

            if (session()->has('wishlist') && !empty(session()->get('wishlist'))) {
                $sessionWishlists = session()->get('wishlist', []);

                foreach ($sessionWishlists as $productId) {
                    Wishlist::firstOrCreate([
                        'user_id' => $userId,
                        'product_id' => $productId
                    ]);
                }

                session()->forget('wishlist');
            }

            $wishlists = $user->wishlists()->with(['product.inventory', 'product.category'])->latest()->get();
            $products = $wishlists->pluck('product');
        } else {
            $productIds = session()->get('wishlist', []);
            $products = Product::with(['inventory', 'category'])->whereIn('id', $productIds)->latest()->get();
        }

        return view('user.wishlist.index', compact('products'));
    }

    /**
     * Store or remove a product from wishlist (AJAX Toggle API).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->product_id;

        if (Auth::check()) {
            $userId = Auth::id();
            $wishlist = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

            if ($wishlist) {
                $wishlist->delete();
                $count = Wishlist::where('user_id', $userId)->count();
                return response()->json([
                    'status' => 'removed',
                    'message' => 'Removed from wishlist!',
                    'wishlistCount' => $count
                ]);
            } else {
                Wishlist::create([
                    'user_id' => $userId,
                    'product_id' => $productId
                ]);
                $count = Wishlist::where('user_id', $userId)->count();
                return response()->json([
                    'status' => 'added',
                    'message' => 'Added to wishlist!',
                    'wishlistCount' => $count
                ]);
            }
        }

        else {
            $wishlist = session()->get('wishlist', []);

            if (in_array($productId, $wishlist)) {
                $wishlist = array_diff($wishlist, [$productId]);
                session()->put('wishlist', $wishlist);
                $count = count($wishlist);
                return response()->json([
                    'status' => 'removed',
                    'message' => 'Removed from wishlist!',
                    'wishlistCount' => $count
                ]);
            } else {
                $wishlist[] = $productId;
                session()->put('wishlist', $wishlist);
                $count = count($wishlist);
                return response()->json([
                    'status' => 'added',
                    'message' => 'Added to wishlist!',
                    'wishlistCount' => $count
                ]);
            }
        }
    }
}
