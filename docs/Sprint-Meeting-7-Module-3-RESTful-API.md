# Sprint Meeting 7 - User Story 14, 15

**Dự án:** Laravel Shopping Cart  
**Ngày:** 18/10/2025  
**Module:** 3.4 & 3.5. RESTful API & API Controller

---

## User Story 14: RESTful API - Product API

### 📋 Miêu tả

**Yêu cầu:** Tạo RESTful API cho Products (GET, POST, PUT, DELETE)  
**Response:** JSON format với HTTP Status codes

### 💻 Code tương ứng

```php
<?php
// File: app/Http/Controllers/Api/ProductApiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    // GET /api/products
    public function index()
    {
        return response()->json(['success' => true, 'data' => Product::all()], 200);
    }
    
    // GET /api/products/{id}
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $product], 200);
    }
    
    // POST /api/products
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json(['success' => true, 'data' => $product], 201);
    }
    
    // PUT /api/products/{id}
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }
        $product->update($request->all());
        return response()->json(['success' => true, 'data' => $product], 200);
    }
    
    // DELETE /api/products/{id}
    public function destroy($id)
    {
        Product::find($id)?->delete();
        return response()->json(['success' => true, 'message' => 'Deleted'], 200);
    }
}
```

```php
<?php
// File: routes/api.php
use App\Http\Controllers\Api\ProductApiController;

Route::apiResource('products', ProductApiController::class);
```

### 📸 Demo

```json
GET /api/products → {"success": true, "data": [12 products]}
GET /api/products/5 → {"success": true, "data": {iPhone 15}}
POST /api/products → 201 Created
PUT /api/products/5 → 200 OK
DELETE /api/products/5 → {"success": true, "message": "Deleted"}
```

---

## User Story 15: API Controller - Cart API

### 📋 Miêu tả

**Yêu cầu:** Cart API với session-based storage  
**Endpoints:** GET, POST, PATCH, DELETE

### 💻 Code tương ứng

```php
<?php
// File: app/Http/Controllers/Api/CartApiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    // GET /api/cart
    public function index(Request $request)
    {
        $sessionId = $request->input('session_id', session()->getId());
        $items = Cart::where('session_id', $sessionId)->with('product')->get();
        $total = $items->sum(fn($i) => $i->product->product_price * $i->quantity);
        
        return response()->json([
            'success' => true,
            'data' => ['items' => $items, 'total' => $total, 'count' => $items->count()]
        ], 200);
    }
    
    // POST /api/cart
    public function store(Request $request)
    {
        $sessionId = $request->input('session_id', session()->getId());
        $item = Cart::where('session_id', $sessionId)
                    ->where('product_id', $request->product_id)
                    ->first();
        
        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            $item = Cart::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'session_id' => $sessionId
            ]);
        }
        
        return response()->json(['success' => true, 'data' => $item->load('product')], 201);
    }
    
    // PATCH /api/cart/{id}
    public function update(Request $request, $id)
    {
        $item = Cart::find($id);
        $item?->update(['quantity' => $request->quantity]);
        return response()->json(['success' => true, 'data' => $item], 200);
    }
    
    // DELETE /api/cart/{id}
    public function destroy($id)
    {
        Cart::find($id)?->delete();
        return response()->json(['success' => true, 'message' => 'Removed'], 200);
    }
}
```

```php
<?php
// routes/api.php
Route::prefix('cart')->group(function () {
    Route::get('/', [CartApiController::class, 'index']);
    Route::post('/', [CartApiController::class, 'store']);
    Route::patch('/{id}', [CartApiController::class, 'update']);
    Route::delete('/{id}', [CartApiController::class, 'destroy']);
});
```

### 📸 Demo

```json
GET /api/cart → {"items": [...], "total": 59980000, "count": 2}
POST /api/cart → Body: {"product_id": 5, "quantity": 2} → 201
PATCH /api/cart/1 → Body: {"quantity": 3} → 200
DELETE /api/cart/1 → {"success": true, "message": "Removed"}
```

---

## ✅ Tóm tắt Sprint Meeting 7

| User Story | Endpoints | Methods | Response |
|------------|-----------|---------|----------|
| **US 14** | `/api/products` | GET, POST, PUT, DELETE | JSON (200, 201, 404) |
| **US 15** | `/api/cart` | GET, POST, PATCH, DELETE | JSON + relationships |

**Kết quả:**
- ✅ 9 API endpoints (5 Product + 4 Cart)
- ✅ JSON responses với status codes
- ✅ Resource relationships (Cart with Product)

---

**Dự án:** Laravel Shopping Cart  
**GitHub:** https://github.com/BBangNguyen/mywebb  
**Live Demo:** https://web-production-3318.up.railway.app  

**Previous:** Sprint Meeting 5 - CRUD (US 11, 12, 13)  
**Next:** Sprint Meeting 8 - Authentication (US 16, 17)
