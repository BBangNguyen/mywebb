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
            // Debug: Log request data
            \Log::info('Checkout process started', [
                'request_data' => $request->all(),
                'session_id' => session()->getId()
            ]);
            
            // Validate dữ liệu
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
            ]);
            
            \Log::info('Validation passed', ['validated' => $validated]);
            
            // Lấy session ID hiện tại
            $sessionId = session()->getId();
            \Log::info('Session ID obtained', ['session_id' => $sessionId]);
            
            // Lấy tất cả items trong giỏ hàng với product relationship
            $cartItems = Cart::where('session_id', $sessionId)
                             ->with('product')
                             ->get();
            
            \Log::info('Cart items retrieved', ['count' => $cartItems->count()]);
            
            if ($cartItems->isEmpty()) {
                \Log::warning('Cart is empty');
                return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
            }
            
            // Xóa TẤT CẢ sản phẩm trong giỏ hàng sau khi đặt hàng thành công
            $deletedCount = Cart::where('session_id', $sessionId)->delete();
            \Log::info('Cart cleared', ['deleted_items' => $deletedCount]);
            
            \Log::info('Checkout completed successfully');
            return redirect('/')->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            // Log lỗi chi tiết
            \Log::error('Checkout Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Trong môi trường development, hiển thị lỗi
            if (config('app.debug')) {
                throw $e;
            }
            
            return redirect()->route('cart')->with('error', 'Có lỗi xảy ra khi xử lý đơn hàng. Vui lòng thử lại!');
        }
    }

}

