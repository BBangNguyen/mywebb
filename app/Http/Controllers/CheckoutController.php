<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->get();
        $totalQuantity = $cartItems->sum('quantity');
        $total = $cartItems->sum(function ($item) {
            return $item->product->product_price * $item->quantity;
        });
    
        return view('checkout', compact('cartItems', 'total', 'totalQuantity'));
    }
    public function process(Request $request)
{
    // Lấy dữ liệu từ form
    $name = $request->name;
    $phone = $request->phone;
    $address = $request->address;
    
    // Lưu thông tin đơn hàng vào database (ví dụ)
    // Order::create([...]);

    // Xóa giỏ hàng sau khi đặt hàng thành công
    session()->forget('cart');

    return redirect('/')->with('success', 'Đặt hàng thành công!');
}

}

