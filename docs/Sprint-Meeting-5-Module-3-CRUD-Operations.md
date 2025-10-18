# Sprint Meeting 5 - User Story 11, 12, 13

**Dự án:** Laravel Shopping Cart  
**Ngày:** 18/10/2025  
**Module:** 3. CRUD Operations (Create - Read - Update - Delete)

---

## User Story 11: READ - Hiển thị & tìm kiếm

### 📋 Miêu tả

**Yêu cầu:** Hiển thị dữ liệu từ database (READ All, READ One, Search)  
**HTTP Method:** GET

### 💻 Code tương ứng

```php
<?php
// File: app/Http/Controllers/ProductController.php

class ProductController extends Controller
{
    // READ All - Hiển thị tất cả
    public function index()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }
    
    // READ One - Hiển thị chi tiết
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product-detail', compact('product'));
    }
    
    // Search - Tìm kiếm
    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $products = Product::where('product_name', 'LIKE', "%$keyword%")->get();
        return view('search', compact('products', 'keyword'));
    }
}
```

```php
<?php
// Routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/search', [ProductController::class, 'search'])->name('search');
```

### 📸 Demo

```
GET / → Product::all() → 12 sản phẩm
GET /product/5 → Product::findOrFail(5) → iPhone 15 Pro Max
GET /search?search=iPhone → WHERE product_name LIKE '%iPhone%' → 2 kết quả
```

---

## User Story 12: CREATE - Thêm mới

### 📋 Miêu tả

**Yêu cầu:** Thêm sản phẩm mới (Form + Store)  
**HTTP Methods:** GET + POST

### 💻 Code tương ứng

```php
<?php
class ProductController extends Controller
{
    // Hiển thị form
    public function create()
    {
        return view('product-create');
    }
    
    // Lưu vào database
    public function store(Request $request)
    {
        Product::create([
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'product_image' => $request->input('product_image'),
            'product_describe' => $request->input('product_describe'),
        ]);
        
        return redirect()->route('home')->with('success', 'Đã thêm sản phẩm!');
    }
}
```

```blade
<!-- Form CREATE -->
<form action="{{ route('product.store') }}" method="POST">
    @csrf
    <input type="text" name="product_name" required>
    <input type="number" name="product_price" required>
    <input type="text" name="product_image" required>
    <textarea name="product_describe" required></textarea>
    <button type="submit">Thêm sản phẩm</button>
</form>
```

### 📸 Demo

```
GET /product/create → Form trống
POST /product/store → INSERT INTO products → Redirect với message
```

---

## User Story 13: UPDATE & DELETE - Sửa & Xóa

### 📋 Miêu tả

**Yêu cầu:** Cập nhật và xóa sản phẩm  
**HTTP Methods:** GET + POST + DELETE

### 💻 Code tương ứng

```php
<?php
class ProductController extends Controller
{
    // Hiển thị form sửa
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product-edit', compact('product'));
    }
    
    // Cập nhật
    public function update(Request $request)
    {
        $product = Product::findOrFail($request->input('id'));
        $product->update($request->only(['product_name', 'product_price', 'product_image', 'product_describe']));
        
        return redirect()->route('home')->with('success', 'Đã cập nhật!');
    }
    
    // Xóa
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('home')->with('success', 'Đã xóa!');
    }
}
```

```blade
<!-- Form UPDATE -->
<form action="{{ route('product.update') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $product->id }}">
    <input type="text" name="product_name" value="{{ $product->product_name }}">
    <button type="submit">Cập nhật</button>
</form>

<!-- Form DELETE -->
<form action="{{ route('product.delete', $product->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button onclick="return confirm('Xóa?')">Xóa</button>
</form>
```

### 📸 Demo

```
GET /product/edit/5 → Form với dữ liệu cũ
POST /product/update → UPDATE products SET ... WHERE id = 5
DELETE /product/delete/5 → DELETE FROM products WHERE id = 5
```

---

## ✅ Tóm tắt Sprint Meeting 5

| User Story | HTTP | Routes | SQL |
|------------|------|--------|-----|
| **US 11: READ** | GET | `/`, `/product/{id}`, `/search` | SELECT |
| **US 12: CREATE** | GET + POST | `/product/create`, `/product/store` | INSERT |
| **US 13: UPDATE/DELETE** | GET + POST + DELETE | `/product/edit/{id}`, `/product/update`, `/product/delete/{id}` | UPDATE, DELETE |

**Kết quả:**
- ✅ CRUD đầy đủ: 7 methods
- ✅ 8 routes (3 READ + 2 CREATE + 2 UPDATE + 1 DELETE)
- ✅ HTTP Methods: GET, POST, DELETE
- ✅ CSRF protection (@csrf, @method)

---

**Dự án:** Laravel Shopping Cart  
**GitHub:** https://github.com/BBangNguyen/mywebb  
**Live Demo:** https://web-production-3318.up.railway.app  

**Previous:** Sprint Meeting 4 - Database & Eloquent (US 8, 9, 10)  
**Next:** Sprint Meeting 6 - Session & Cart (US 14, 15, 16)
