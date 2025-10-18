# Sprint Meeting 4 - User Story 8, 9, 10

**Dự án:** Laravel Shopping Cart  
**Ngày:** 18/10/2025  
**Module:** 2.4. Database - Migration & Eloquent ORM

---

## User Story 8: Migration - Tạo cấu trúc bảng

### 📋 Miêu tả

**Yêu cầu:** Tạo 2 bảng database:
- `products`: Lưu sản phẩm (tên, giá, hình, mô tả)
- `carts`: Lưu giỏ hàng (product_id, quantity)

**Mục tiêu:** Định nghĩa schema, foreign key, hỗ trợ rollback

### 💻 Code tương ứng

```php
<?php
// File: database/migrations/2025_10_01_000000_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->float('product_price');
            $table->string('product_image');
            $table->text('product_describe');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
```

```php
<?php
// File: database/migrations/2025_10_01_000001_create_carts_table.php

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
```

### 📸 Demo

```powershell
# Tạo và chạy migration
php artisan make:migration create_products_table
php artisan migrate

# Output:
# INFO  Running migrations.
#   2025_10_01_000000_create_products_table ... DONE
#   2025_10_01_000001_create_carts_table ...... DONE

# Rollback
php artisan migrate:rollback
php artisan migrate:fresh --seed  # Drop all + migrate + seed
```

---

## User Story 9: Eloquent ORM - Tạo Models

### 📋 Miêu tả

**Yêu cầu:** Tạo Models với Eloquent ORM:
- Product Model: CRUD sản phẩm
- Cart Model: CRUD giỏ hàng + relationship

**Mục tiêu:** Thay raw SQL bằng Eloquent, định nghĩa relationships

### 💻 Code tương ứng

```php
<?php
// File: app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'product_price',
        'product_image',
        'product_describe',
    ];
}
```

```php
<?php
// File: app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['product_id', 'quantity'];

    // Relationship: Cart belongsTo Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

### 📸 Demo

```php
<?php
// CRUD với Eloquent
$products = Product::all();                    // SELECT *
$product = Product::find(1);                   // WHERE id = 1
$product = Product::where('product_name', 'LIKE', '%iPhone%')->get();

// Create
Product::create(['product_name' => 'iPhone 16', 'product_price' => 29990000, ...]);

// Update
$product = Product::find(1);
$product->product_price = 25000000;
$product->save();

// Delete
Product::find(1)->delete();

// Relationship (Eager Loading - Tránh N+1)
$cartItems = Cart::with('product')->get();
foreach ($cartItems as $item) {
    echo $item->product->product_name;
}
```

---

## User Story 10: Seeder - Khởi tạo dữ liệu mẫu

### 📋 Miêu tả

**Yêu cầu:** Tạo 12 sản phẩm mẫu cho Shopping Cart

**Mục tiêu:** Populate database với dữ liệu test, dễ reset

### 💻 Code tương ứng

```php
<?php
// File: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            ['product_name' => 'Apple MacBook Pro', 'product_price' => 17990000, 
             'product_image' => './img/product1.png', 'product_describe' => 'Máy tính đẹp'],
            ['product_name' => 'iPhone 15 Pro Max', 'product_price' => 29990000, 
             'product_image' => './img/product5.png', 'product_describe' => 'iPhone mới nhất'],
            ['product_name' => 'AirPods Pro Gen 2', 'product_price' => 6490000, 
             'product_image' => './img/product8.png', 'product_describe' => 'Tai nghe chống ồn'],
            ['product_name' => 'Samsung Galaxy S24 Ultra', 'product_price' => 31990000, 
             'product_image' => './img/product9.png', 'product_describe' => 'Flagship Android'],
            // ... 8 sản phẩm nữa (tổng 12 sản phẩm)
        ]);
    }
}
```

### 📸 Demo

```powershell
# Chạy seeder
php artisan db:seed

# Output:
# INFO  Seeding database.
#   Database\Seeders\DatabaseSeeder ... DONE

# Drop all, migrate, và seed
php artisan migrate:fresh --seed

# Kiểm tra
# mysql> SELECT COUNT(*) FROM products;
# Output: 12
```

---

## 🔄 Quy trình hoàn chỉnh

```
1. Migration → 2. Migrate → 3. Model → 4. Seeder → 5. Eloquent Query

php artisan make:migration create_products_table
php artisan migrate
php artisan make:model Product
php artisan db:seed
Product::all()  // Sử dụng trong Controller
```

---

## ✅ Tóm tắt Sprint Meeting 4

| User Story | Miêu tả | Command |
|------------|---------|---------|
| **US 8: Migration** | Tạo cấu trúc bảng | `php artisan migrate` |
| **US 9: Eloquent** | Models & Relationships | `php artisan make:model` |
| **US 10: Seeder** | Dữ liệu mẫu | `php artisan db:seed` |

**Kết quả:**
- ✅ 2 bảng: `products` (5 cols), `carts` (3 cols)
- ✅ Foreign key: `carts.product_id` → `products.id` (cascade)
- ✅ Relationship: Cart `belongsTo` Product
- ✅ 12 sản phẩm seed data

**Database Schema:**

```
products              carts
├─ id (PK)           ├─ id (PK)
├─ product_name      ├─ product_id (FK) ──→ products.id
├─ product_price     ├─ quantity
├─ product_image     ├─ created_at
├─ product_describe  └─ updated_at
├─ created_at
└─ updated_at
```

---

**Dự án:** Laravel Shopping Cart  
**GitHub:** https://github.com/BBangNguyen/mywebb  
**Live Demo:** https://web-production-3318.up.railway.app  

**Previous:** Sprint Meeting 3 - Route, Controller, View (US 5, 6, 7)  
**Next:** Sprint Meeting 5 - Authentication & Authorization (US 11, 12, 13)
