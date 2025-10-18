# Sprint Meeting 3 - User Story 5, 6, 7

**Dự án:** Laravel Shopping Cart  
**Ngày:** 18/10/2025  

---

## User Story 5: Route - Định nghĩa URL

### 📋 Miêu tả

**Yêu cầu:** Thiết lập hệ thống routing cho Shopping Cart, bao gồm:
- Route hiển thị danh sách sản phẩm (trang chủ)
- Route tìm kiếm sản phẩm
- Route quản lý giỏ hàng (xem, thêm, cập nhật, xóa)
- Route thanh toán

**Mục tiêu:**
- Ánh xạ URL với Controller methods
- Đặt tên routes để dễ sử dụng
- Hỗ trợ route parameters (id sản phẩm, id giỏ hàng)

### 💻 Code tương ứng

```php
<?php
// File: routes/web.php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Route hiển thị danh sách sản phẩm (Trang chủ)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Route tìm kiếm sản phẩm
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Route giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');

// Route thanh toán
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
```

**Giải thích:**
- `Route::get()` - HTTP GET request (hiển thị trang)
- `Route::post()` - HTTP POST request (thêm dữ liệu)
- `Route::patch()` - HTTP PATCH request (cập nhật)
- `Route::delete()` - HTTP DELETE request (xóa)
- `->name()` - Đặt tên route để sử dụng trong view/controller
- `{id}` - Route parameter (ID động)

### 📸 Demo

**Xem danh sách routes:**

```powershell
php artisan route:list
```

**Output:**
```
GET|HEAD   /                   home              ProductController@index
GET|HEAD   /search             search            ProductController@search
GET|HEAD   /cart               cart              CartController@index
POST       /cart/add           cart.add          CartController@add
PATCH      /cart/update/{id}   cart.update       CartController@update
DELETE     /cart/delete/{id}   cart.delete       CartController@delete
GET|HEAD   /checkout           checkout          CartController@checkout
```

**Sử dụng trong View:**
```blade
{{-- Sử dụng named route --}}
<a href="{{ route('home') }}">Trang chủ</a>
<a href="{{ route('cart') }}">Giỏ hàng</a>

{{-- Route có parameter --}}
<form action="{{ route('cart.update', $item->id) }}" method="POST">
    @csrf
    @method('PATCH')
</form>
```

---

## User Story 6: Controllers - Xử lý logic nghiệp vụ

### 📋 Miêu tả

**Yêu cầu:** Tạo Controllers để xử lý các chức năng chính:

**ProductController:**
- Hiển thị danh sách sản phẩm
- Tìm kiếm sản phẩm theo tên

**CartController:**
- Hiển thị giỏ hàng với tổng tiền
- Thêm sản phẩm vào giỏ hàng
- Cập nhật số lượng sản phẩm trong giỏ
- Xóa sản phẩm khỏi giỏ hàng
- Hiển thị trang thanh toán

**Mục tiêu:**
- Tách biệt logic nghiệp vụ khỏi View
- Tương tác với Model để query database
- Xử lý request và trả về response phù hợp

### 💻 Code tương ứng

**1. ProductController**

```php
<?php
// File: app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index()
    {
        // Lấy tất cả sản phẩm từ database
        $products = Product::all();
        
        // Trả về view với dữ liệu products
        return view('index', compact('products'));
    }
    
    /**
     * Tìm kiếm sản phẩm
     */
    public function search(Request $request)
    {
        // Lấy từ khóa tìm kiếm
        $keyword = $request->input('search');
        
        // Tìm sản phẩm có tên chứa keyword
        $products = Product::where('product_name', 'like', "%$keyword%")
                           ->get();
        
        // Trả về view search với kết quả
        return view('search', compact('products', 'keyword'));
    }
}
```

**2. CartController**

```php
<?php
// File: app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        // Lấy các items trong giỏ hàng của session hiện tại
        $cartItems = Cart::where('session_id', session()->getId())
                         ->with('product') // Eager loading product
                         ->get();
        
        // Tính tổng tiền
        $total = $cartItems->sum(function ($item) {
            return $item->product->product_price * $item->quantity;
        });
        
        return view('cart', compact('cartItems', 'total'));
    }
    
    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $cartItem = Cart::where('session_id', session()->getId())
                        ->where('product_id', $productId)
                        ->first();
        
        if ($cartItem) {
            // Nếu đã có, tăng số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Nếu chưa có, tạo mới
            Cart::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'session_id' => session()->getId()
            ]);
        }
        
        return redirect()->route('cart')
                        ->with('success', 'Đã thêm vào giỏ hàng!');
    }
    
    /**
     * Cập nhật số lượng sản phẩm
     */
    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->input('quantity');
        $cart->save();
        
        return redirect()->route('cart')
                        ->with('success', 'Đã cập nhật giỏ hàng!');
    }
    
    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function delete($id)
    {
        Cart::findOrFail($id)->delete();
        
        return redirect()->route('cart')
                        ->with('success', 'Đã xóa sản phẩm!');
    }
    
    /**
     * Hiển thị trang thanh toán
     */
    public function checkout()
    {
        $cartItems = Cart::where('session_id', session()->getId())
                         ->with('product')
                         ->get();
        
        // Nếu giỏ hàng trống, redirect về trang giỏ hàng
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')
                           ->with('error', 'Giỏ hàng trống!');
        }
        
        // Tính tổng tiền
        $total = $cartItems->sum(function ($item) {
            return $item->product->product_price * $item->quantity;
        });
        
        return view('checkout', compact('cartItems', 'total'));
    }
}
```

### 📸 Demo

**Tạo Controller bằng Artisan:**

```powershell
php artisan make:controller ProductController
php artisan make:controller CartController
```

**Output:**
```
INFO  Controller [app/Http/Controllers/ProductController.php] created successfully.
INFO  Controller [app/Http/Controllers/CartController.php] created successfully.
```

**Cấu trúc thư mục:**
```
app/Http/Controllers/
├── ProductController.php
├── CartController.php
└── Controller.php (base)
```

**Flow hoạt động:**

```
Request: POST /cart/add (product_id=1, quantity=2)
         ↓
Route::post('/cart/add', [CartController::class, 'add'])
         ↓
CartController::add($request)
├─ Kiểm tra sản phẩm trong giỏ
├─ Tạo hoặc cập nhật Cart
└─ Redirect về /cart với message
         ↓
Response: Hiển thị giỏ hàng với thông báo "Đã thêm vào giỏ hàng!"
```

---

## User Story 7: View - Hiển thị giao diện

### 📋 Miêu tả

**Yêu cầu:** Tạo các View (Blade templates) để hiển thị giao diện:

1. **Trang chủ (index.blade.php):**
   - Hiển thị grid sản phẩm với hình ảnh, tên, giá
   - Form tìm kiếm sản phẩm
   - Nút "Thêm vào giỏ" cho mỗi sản phẩm

2. **Giỏ hàng (cart.blade.php):**
   - Bảng danh sách sản phẩm trong giỏ
   - Form cập nhật số lượng
   - Nút xóa sản phẩm
   - Hiển thị tổng tiền
   - Nút "Thanh toán"

**Mục tiêu:**
- Sử dụng Blade syntax để hiển thị dữ liệu động
- Xử lý CSRF protection cho forms
- Hiển thị thông báo success/error
- Responsive và user-friendly

### 💻 Code tương ứng

**1. Trang chủ - Danh sách sản phẩm**

```blade
<!-- File: resources/views/index.blade.php -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Trang chủ</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>🛒 Shopping Cart</h1>
            <nav>
                <a href="{{ route('home') }}">Trang chủ</a>
                <a href="{{ route('cart') }}">Giỏ hàng</a>
            </nav>
        </header>
        
        {{-- Form tìm kiếm --}}
        <div class="search-box">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm...">
                <button type="submit">🔍 Tìm</button>
            </form>
        </div>
        
        {{-- Grid sản phẩm --}}
        <div class="product-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <img src="{{ $product->product_image }}" 
                         alt="{{ $product->product_name }}">
                    
                    <h3>{{ $product->product_name }}</h3>
                    
                    <p class="price">
                        {{ number_format($product->product_price) }} VND
                    </p>
                    
                    <p class="description">
                        {{ Str::limit($product->product_describe, 50) }}
                    </p>
                    
                    {{-- Form thêm vào giỏ --}}
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-add-cart">
                            🛒 Thêm vào giỏ
                        </button>
                    </form>
                </div>
            @empty
                <p class="no-products">Không có sản phẩm nào</p>
            @endforelse
        </div>
    </div>
</body>
</html>
```

**2. Giỏ hàng**

```blade
<!-- File: resources/views/cart.blade.php -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>🛒 Giỏ hàng của bạn</h1>
        
        {{-- Thông báo thành công --}}
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif
        
        {{-- Kiểm tra giỏ hàng có rỗng không --}}
        @if($cartItems->isEmpty())
            <div class="empty-cart">
                <p>Giỏ hàng của bạn đang trống</p>
                <a href="{{ route('home') }}" class="btn-continue">
                    ← Tiếp tục mua sắm
                </a>
            </div>
        @else
            {{-- Bảng sản phẩm --}}
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="product-info">
                                <img src="{{ $item->product->product_image }}" 
                                     alt="{{ $item->product->product_name }}"
                                     width="60">
                                <span>{{ $item->product->product_name }}</span>
                            </td>
                            
                            <td class="price">
                                {{ number_format($item->product->product_price) }} VND
                            </td>
                            
                            <td class="quantity">
                                <form action="{{ route('cart.update', $item->id) }}" 
                                      method="POST" 
                                      class="update-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" 
                                           name="quantity" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="99">
                                    <button type="submit" class="btn-update">
                                        ✔️ Cập nhật
                                    </button>
                                </form>
                            </td>
                            
                            <td class="total">
                                {{ number_format($item->product->product_price * $item->quantity) }} VND
                            </td>
                            
                            <td class="actions">
                                <form action="{{ route('cart.delete', $item->id) }}" 
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-delete"
                                            onclick="return confirm('Xóa sản phẩm này?')">
                                        🗑️ Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Tổng cộng:</strong></td>
                        <td colspan="2" class="grand-total">
                            <strong>{{ number_format($total) }} VND</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
            
            {{-- Nút hành động --}}
            <div class="cart-actions">
                <a href="{{ route('home') }}" class="btn-continue">
                    ← Tiếp tục mua sắm
                </a>
                <a href="{{ route('checkout') }}" class="btn-checkout">
                    Thanh toán →
                </a>
            </div>
        @endif
    </div>
</body>
</html>
```

**3. Blade Syntax sử dụng**

```blade
{{-- Hiển thị biến (auto-escape HTML) --}}
{{ $product->product_name }}

{{-- Hiển thị với function --}}
{{ number_format($price) }}
{{ Str::limit($text, 50) }}

{{-- If-Else --}}
@if($cartItems->isEmpty())
    <p>Giỏ hàng trống</p>
@else
    <table>...</table>
@endif

{{-- Foreach với empty fallback --}}
@forelse($products as $product)
    <div>{{ $product->name }}</div>
@empty
    <p>Không có sản phẩm</p>
@endforelse

{{-- CSRF Token (bắt buộc) --}}
@csrf

{{-- Method Spoofing --}}
@method('PATCH')
@method('DELETE')

{{-- Session Flash Message --}}
@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

{{-- Asset helper --}}
{{ asset('css/style.css') }}
{{ asset('img/product.png') }}

{{-- Route helper --}}
{{ route('home') }}
{{ route('cart.update', $item->id) }}
```

### 📸 Demo

**1. Trang chủ - Hiển thị 12 sản phẩm**

```
┌─────────────────────────────────────────────┐
│  🛒 Shopping Cart                           │
│  [Trang chủ] [Giỏ hàng]                    │
├─────────────────────────────────────────────┤
│  [Tìm kiếm sản phẩm...        ] [🔍 Tìm]  │
├─────────────────────────────────────────────┤
│  ┌──────┐  ┌──────┐  ┌──────┐  ┌──────┐   │
│  │ 📱   │  │ 💻   │  │ 🎧   │  │ 📷   │   │
│  │iPhone│  │MacBk │  │Airpd │  │Camera│   │
│  │29.9M │  │17.9M │  │6.49M │  │14.9M │   │
│  │[Thêm]│  │[Thêm]│  │[Thêm]│  │[Thêm]│   │
│  └──────┘  └──────┘  └──────┘  └──────┘   │
│  ... (8 sản phẩm nữa)                       │
└─────────────────────────────────────────────┘
```

**2. Giỏ hàng với 3 sản phẩm**

```
┌─────────────────────────────────────────────────────────┐
│  🛒 Giỏ hàng của bạn                                    │
│  ✅ Đã thêm vào giỏ hàng!                               │
├─────────────────────────────────────────────────────────┤
│  Sản phẩm          │ Giá        │ SL  │ Tổng      │ Xóa│
│  📱 iPhone 15 Pro  │ 29,990,000 │ [2] │ 59,980,000│ 🗑️│
│  💻 MacBook Pro    │ 17,990,000 │ [1] │ 17,990,000│ 🗑️│
│  🎧 AirPods Pro    │  6,490,000 │ [3] │ 19,470,000│ 🗑️│
├─────────────────────────────────────────────────────────┤
│  Tổng cộng:                              97,440,000 VND │
├─────────────────────────────────────────────────────────┤
│  [← Tiếp tục mua sắm]           [Thanh toán →]         │
└─────────────────────────────────────────────────────────┘
```

**3. Giỏ hàng trống**

```
┌─────────────────────────────────────┐
│  🛒 Giỏ hàng của bạn               │
├─────────────────────────────────────┤
│                                     │
│     Giỏ hàng của bạn đang trống    │
│                                     │
│     [← Tiếp tục mua sắm]           │
│                                     │
└─────────────────────────────────────┘
```

**4. Screenshot thực tế từ Railway deployment:**

Live URL: https://web-production-3318.up.railway.app

- Trang chủ: Hiển thị 12 sản phẩm với hình ảnh từ Unsplash
- Giỏ hàng: Tính tổng tiền tự động, cập nhật số lượng realtime
- Tìm kiếm: Lọc sản phẩm theo tên (case-insensitive)

---

## 🔄 Tổng kết quy trình MVC

```
1. User nhập URL hoặc click button
         ↓
2. routes/web.php mapping URL → Controller
         ↓
3. Controller xử lý logic
   ├─ Nhận Request data
   ├─ Gọi Model query Database
   └─ Chuẩn bị dữ liệu cho View
         ↓
4. View (Blade) render HTML với data
         ↓
5. Response trả về Browser
         ↓
6. Browser hiển thị kết quả cho User
```

**Ví dụ cụ thể: Thêm sản phẩm vào giỏ hàng**

```
1. User click "Thêm vào giỏ" (product_id = 5)
2. POST /cart/add
3. Route::post('/cart/add') → CartController::add()
4. Controller:
   - Nhận $request->input('product_id') = 5
   - Kiểm tra Cart có sản phẩm này chưa
   - Nếu có: tăng quantity
   - Nếu chưa: Cart::create()
   - redirect()->route('cart')
5. GET /cart
6. Route::get('/cart') → CartController::index()
7. Controller:
   - Cart::where('session_id')->get()
   - Tính total
   - return view('cart', compact('cartItems', 'total'))
8. Blade render resources/views/cart.blade.php
9. HTML response
10. Browser hiển thị giỏ hàng với thông báo "Đã thêm vào giỏ hàng!"
```

---

## ✅ Tóm tắt Sprint Meeting 3

| User Story | Miêu tả | File chính | Công nghệ |
|------------|---------|------------|-----------|
| **US 5: Route** | Định nghĩa URL mapping | `routes/web.php` | Laravel Routing |
| **US 6: Controllers** | Xử lý logic nghiệp vụ | `app/Http/Controllers/*.php` | MVC Pattern |
| **US 7: View** | Hiển thị giao diện | `resources/views/*.blade.php` | Blade Template |

**Kết quả đạt được:**
- ✅ 7 routes chính (home, search, cart CRUD, checkout)
- ✅ 2 Controllers với 7 methods
- ✅ 2 Views chính (index, cart)
- ✅ CSRF protection cho tất cả forms
- ✅ Session-based cart
- ✅ Flash messages
- ✅ Responsive UI

**Database queries thực hiện:**
```sql
-- Lấy tất cả sản phẩm
SELECT * FROM products;

-- Tìm kiếm sản phẩm
SELECT * FROM products WHERE product_name LIKE '%iPhone%';

-- Lấy giỏ hàng
SELECT * FROM carts WHERE session_id = 'xyz' JOIN products;

-- Thêm vào giỏ
INSERT INTO carts (product_id, quantity, session_id) VALUES (5, 1, 'xyz');

-- Cập nhật số lượng
UPDATE carts SET quantity = 3 WHERE id = 10;

-- Xóa sản phẩm
DELETE FROM carts WHERE id = 10;
```

---

**Dự án:** Laravel Shopping Cart  
**GitHub:** https://github.com/BBangNguyen/mywebb  
**Live Demo:** https://web-production-3318.up.railway.app  

**Previous:** Sprint Meeting 2 - Laravel Framework (US 1.6, 1.7, 1.8)  
**Next:** Sprint Meeting 4 - Database & Eloquent ORM (US 8, 9, 10)
