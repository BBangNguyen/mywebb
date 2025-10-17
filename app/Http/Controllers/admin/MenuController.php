<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;


class MenuController extends Controller
{
    public function create(){
        return view('admin.menu.create', [
            'title' => 'Thêm mới menu'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'describe' => 'nullable|string',
        ]);

        $product = new Product();
        $product->product_name = $request->input('name');
        $product->product_price = $request->input('price');
        $product->product_image = $request->input('image');
        $product->product_describe = $request->input('describe');
        $product->save();

        return redirect()->back()->with('success', 'Thêm mới menu thành công');
    }
    public function list(){
        $products = Product::all();
        return view('admin.menu.list', [
            'title' => 'Danh sách menu',
            'products' => $products
        ]);
    }
    public function edit($id){
        $product = Product::find($id);
        return view('admin.menu.edit', [
            'title' => 'Chỉnh sửa sản phẩm',
            'product' => $product
        ]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'describe' => 'nullable|string',
        ]);

        $product = Product::find($id);
        $product->product_name = $request->input('name');
        $product->product_price = $request->input('price');
        $product->product_image = $request->input('image');
        $product->product_describe = $request->input('describe');
        $product->save();

        return redirect()->back()->with('success', 'Chỉnh sửa menu thành công');
    }
    public function delete($id){
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('success', 'Xóa menu thành công');
    }
}
