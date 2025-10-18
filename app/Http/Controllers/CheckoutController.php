<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        // Lấy session ID hiện tại
        $sessionId = session()->getId();
        
        // Lấy cart items của user hiện tại
        $cartItems = Cart::where('session_id', $sessionId)
                         ->with('product')
                         ->get();
        
        // Nếu giỏ hàng trống, redirect về trang giỏ hàng
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
        }
        
        $totalQuantity = $cartItems->sum('quantity');
        $total = $cartItems->sum(function ($item) {
            return $item->product->product_price * $item->quantity;
        });
    
        return view('checkout', compact('cartItems', 'total', 'totalQuantity'));
    }
    public function process(Request $request)
    {
        try {
            // Validate dữ liệu
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
            ]);
            
            // Lấy session ID hiện tại
            $sessionId = session()->getId();
            
            // Lấy tất cả items trong giỏ hàng với product relationship
            $cartItems = Cart::where('session_id', $sessionId)
                             ->with('product')
                             ->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
            }
            
            // TODO: Lưu thông tin đơn hàng vào database
            // Order::create([
            //     'customer_name' => $validated['name'],
            //     'customer_phone' => $validated['phone'],
            //     'customer_address' => $validated['address'],
            //     'total' => $cartItems->sum(function($item) {
            //         return $item->product->product_price * $item->quantity;
            //     }),
            //     'status' => 'pending'
            // ]);
            
            // Xóa TẤT CẢ sản phẩm trong giỏ hàng sau khi đặt hàng thành công
            Cart::where('session_id', $sessionId)->delete();
            
            return redirect('/')->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng.');
            
        } catch (\Exception $e) {
            // Log lỗi
            \Log::error('Checkout Error: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            return redirect()->route('cart')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

}

