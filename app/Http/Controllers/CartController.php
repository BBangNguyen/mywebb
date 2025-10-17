<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
{
    $cartItems = Cart::with('product')->get();

    // Tính tổng giá trị giỏ hàng
    $total = $cartItems->sum(function ($item) {
        return $item->product->product_price * $item->quantity;
    });

    // Tính tổng số lượng sản phẩm
    $totalQuantity = $cartItems->sum('quantity');

    return view('cart', compact('cartItems', 'total', 'totalQuantity'));
}


    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $cartItem = Cart::where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }



    public function remove(Request $request)
{
    $productId = $request->input('product_id');
    
    // Kiểm tra xem sản phẩm có trong giỏ hàng không
    $cartItem = Cart::where('product_id', $productId)->first();

    if ($cartItem) {
        $cartItem->delete();
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    } else {
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
    }
}


public function update(Request $request, $id)
{
    $cartItem = Cart::where('product_id', $id)->first();

    if (!$cartItem) {
        return back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
    }

    if ($request->has('increase_quantity')) {
        $cartItem->quantity += 1;
    } elseif ($request->has('decrease_quantity')) {
        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        } else {
            return back()->with('error', 'Số lượng tối thiểu là 1!');
        }
    }

    $cartItem->save();

    return back()->with('success', 'Cập nhật giỏ hàng thành công!');
}


}