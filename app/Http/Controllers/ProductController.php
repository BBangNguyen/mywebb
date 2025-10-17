<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cartItems = Cart::with('product')->get();
        $totalQuantity = $cartItems->sum('quantity');
        return view('index', compact('products', 'totalQuantity'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('product_name', 'LIKE', "%{$query}%")
                            ->orWhere('product_describe', 'LIKE', "%{$query}%")
                            ->get();
        $cartItems = Cart::with('product')->get();
        $totalQuantity = $cartItems->sum('quantity');
        return view('search', compact('products', 'totalQuantity'));
    }
}