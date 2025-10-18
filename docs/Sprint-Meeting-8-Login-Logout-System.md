# 🔐 Hệ thống Login/Logout - Laravel Shopping Cart

## 📋 Tổng quan

Hệ thống xác thực người dùng hoàn chỉnh với các tính năng:
- ✅ **Login** (Đăng nhập)
- ✅ **Logout** (Đăng xuất)
- ✅ **Register** (Đăng ký)
- ✅ **Session Management**
- ✅ **Middleware Protection**

---

## 🎯 Tính năng đã implement

### 1️⃣ Đăng nhập (Login)

**URL:** `/admin/user/login`  
**Method:** GET (hiển thị form), POST (xử lý)

**Form fields:**
- Email (required, email format)
- Password (required)
- Remember Me (checkbox)

**Flow:**
```
User nhập email/password
  ↓
POST /admin/user/login/store
  ↓
LoginController@store()
  ↓
Auth::attempt() → Kiểm tra credentials
  ↓
├─ Success: Redirect to /admin (dashboard)
│  └─ Session regenerate (bảo mật)
│
└─ Fail: Redirect back với error message
```

**Code:**
```php
// LoginController@store()
if(Auth::attempt([
    'email' => $request->email,
    'password' => $request->password,
], $request->remember)){
    $request->session()->regenerate();
    return redirect()->route('admin')->with('success', 'Đăng nhập thành công!');
}
return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng!');
```

---

### 2️⃣ Đăng xuất (Logout)

**URL:** `/admin/user/logout`  
**Method:** POST (bảo mật với CSRF token)

**Flow:**
```
User click "Đăng xuất" (navbar dropdown)
  ↓
POST /admin/user/logout (CSRF protected)
  ↓
LoginController@logout()
  ↓
Auth::logout()
Session::invalidate()
Token::regenerate()
  ↓
Redirect to /admin/user/login
```

**Code:**
```php
public function logout(Request $request){
    Auth::logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login')->with('success', 'Đã đăng xuất thành công!');
}
```

**Security:**
- ✅ Hủy session hiện tại
- ✅ Regenerate CSRF token (chống session fixation)
- ✅ Redirect về trang login

---

### 3️⃣ Đăng ký (Register)

**URL:** `/admin/user/register`  
**Method:** GET (hiển thị form), POST (xử lý)

**Form fields:**
- Họ và tên (required, max 255)
- Email (required, email, unique)
- Password (required, min 6, confirmed)
- Password Confirmation (required)

**Validation rules:**
```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:6|confirmed',
]
```

**Flow:**
```
User điền form đăng ký
  ↓
POST /admin/user/register/store
  ↓
RegisterController@store()
  ↓
Validate dữ liệu
  ↓
├─ Validation fail: Redirect back với errors
│
└─ Success:
   ├─ Hash::make($password) → Mã hóa mật khẩu
   ├─ User::create() → Lưu vào database
   └─ Redirect to login với success message
```

**Code:**
```php
User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
]);

return redirect()->route('login')
    ->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
```

---

## 🛡️ Bảo mật

### Middleware Protection

**Routes được bảo vệ:**
```php
Route::middleware('auth')->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('/', [MainController::class, 'index'])->name('admin');
        
        Route::prefix('menus')->group(function(){
            // Tất cả admin routes
        });
    });
});
```

**Cơ chế:**
- ❌ Chưa login → Redirect to `/admin/user/login`
- ✅ Đã login → Cho phép truy cập admin pages

### Session Security

```php
// Login: Regenerate session ID (chống session fixation)
$request->session()->regenerate();

// Logout: Hủy session + regenerate token
$request->session()->invalidate();
$request->session()->regenerateToken();
```

### Password Hashing

```php
// Lưu password: LUÔN hash
'password' => Hash::make($request->password)

// Model User: Auto-cast password
protected function casts(): array {
    return [
        'password' => 'hashed',
    ];
}
```

---

## 🎨 UI/UX

### Navbar Dropdown (Admin)

```html
<ul class="navbar-nav ms-auto">
  <li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
      <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
    </a>
    <div class="dropdown-menu dropdown-menu-end">
      <a href="#" class="dropdown-item">
        <i class="bi bi-person me-2"></i> Profile
      </a>
      <div class="dropdown-divider"></div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="dropdown-item text-danger">
          <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
        </button>
      </form>
    </div>
  </li>
</ul>
```

**Hiển thị:**
- Avatar icon + tên user
- Dropdown menu: Profile, Đăng xuất
- Logout button màu đỏ (text-danger)

### Alert Messages

```php
// Login page
@include('admin.alert')

// admin.alert.blade.php
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif
```

### Validation Errors

```html
@error('email')
  <div class="text-danger mb-2">{{ $message }}</div>
@enderror
```

---

## 📊 Database

### Users Table

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Test Users (Seeder)

```php
// AdminUserSeeder.php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('123456'),
]);

User::create([
    'name' => 'Nguyễn Văn Bằng',
    'email' => 'bang@example.com',
    'password' => Hash::make('123456'),
]);
```

**Chạy seeder:**
```bash
php artisan db:seed --class=AdminUserSeeder
```

---

## 🎬 Demo Flow

### Kịch bản 1: Đăng ký → Đăng nhập

```
1. Vào http://localhost:8000/admin/user/register
2. Điền form:
   - Họ và tên: "Test User"
   - Email: "test@example.com"
   - Password: "123456"
   - Confirm Password: "123456"
3. Click "Đăng ký"
4. ✅ Redirect to /admin/user/login với message "Đăng ký thành công!"
5. Nhập email/password vừa tạo
6. Click "Sign In"
7. ✅ Redirect to /admin (dashboard)
8. Navbar hiển thị: "Test User" với dropdown
```

### Kịch bản 2: Đăng nhập với Remember Me

```
1. Vào /admin/user/login
2. Email: "admin@example.com"
3. Password: "123456"
4. ✅ Tick "Remember Me"
5. Click "Sign In"
6. → Session sẽ tồn tại lâu hơn (120 phút → vài ngày)
7. Đóng browser, mở lại → Vẫn đăng nhập
```

### Kịch bản 3: Đăng xuất

```
1. Đang ở /admin (đã login)
2. Click dropdown "Admin" (góc phải navbar)
3. Click "Đăng xuất" (màu đỏ)
4. ✅ POST /admin/user/logout
5. Session bị hủy
6. Redirect to /admin/user/login
7. Message: "Đã đăng xuất thành công!"
```

### Kịch bản 4: Truy cập admin khi chưa login

```
1. Logout hoặc xóa session
2. Truy cập: http://localhost:8000/admin
3. ❌ Middleware 'auth' chặn
4. Redirect to /admin/user/login
5. Message: "Please login to continue"
```

---

## 🔧 Routes Summary

```php
// Public routes (không cần auth)
GET  /admin/user/login          → Login form
POST /admin/user/login/store    → Process login
GET  /admin/user/register       → Register form
POST /admin/user/register/store → Process register
POST /admin/user/logout         → Logout (CSRF protected)

// Protected routes (cần auth middleware)
GET  /admin                     → Admin dashboard
GET  /admin/menus/list          → Menu management
...
```

---

## 📸 Screenshots

### 1. Login Page
```
┌────────────────────────────────────────┐
│          Admin Login                   │
├────────────────────────────────────────┤
│  Sign in to start your session        │
│                                        │
│  ✉️ Email                               │
│  [admin@example.com              ]    │
│                                        │
│  🔒 Password                            │
│  [••••••                         ]    │
│                                        │
│  ☑️ Remember Me                         │
│                                        │
│  [Sign In]                            │
│                                        │
│  Chưa có tài khoản? Đăng ký ngay       │
└────────────────────────────────────────┘
```

### 2. Register Page
```
┌────────────────────────────────────────┐
│       Admin Register                   │
├────────────────────────────────────────┤
│  Đăng ký tài khoản mới                 │
│                                        │
│  👤 Họ và tên                           │
│  [Nguyễn Văn A               ]        │
│                                        │
│  ✉️ Email                               │
│  [test@example.com           ]        │
│                                        │
│  🔒 Mật khẩu                            │
│  [••••••                     ]        │
│                                        │
│  🔒 Xác nhận mật khẩu                   │
│  [••••••                     ]        │
│                                        │
│  [Đăng ký]                            │
│                                        │
│  Đã có tài khoản? Đăng nhập            │
└────────────────────────────────────────┘
```

### 3. Admin Navbar (Logged In)
```
┌────────────────────────────────────────┐
│ ☰ Home  Contact        👤 Admin  ▼    │
│                                        │
│  Dropdown menu:                        │
│  ┌─────────────────┐                  │
│  │ 👤 Profile       │                  │
│  ├─────────────────┤                  │
│  │ 🚪 Đăng xuất     │ (màu đỏ)          │
│  └─────────────────┘                  │
└────────────────────────────────────────┘
```

---

## 🚀 Deployment

### Environment Variables

```env
# .env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
```

### Railway Deployment

```bash
# Push to GitHub
git add .
git commit -m "feat: Add login/logout/register system"
git push origin main

# Railway auto-deploy
# Migrations chạy tự động: php artisan migrate --force
```

### Tạo Admin User trên Production

```bash
# SSH vào Railway container hoặc dùng Railway CLI
php artisan db:seed --class=AdminUserSeeder
```

Hoặc dùng Tinker:
```bash
php artisan tinker
>>> User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('123456')]);
```

---

## ✅ Checklist

**Hoàn thành:**
- [x] LoginController với index() và store()
- [x] RegisterController với index() và store()
- [x] Logout function với session invalidate
- [x] Routes: /login, /register, /logout
- [x] Views: login.blade.php, register.blade.php
- [x] Navbar dropdown với user name
- [x] Middleware 'auth' protection
- [x] Alert messages (success/error)
- [x] Validation errors display
- [x] AdminUserSeeder với 2 test users
- [x] Password hashing (Hash::make)
- [x] Session regeneration (security)
- [x] CSRF protection
- [x] Remember Me functionality

**Test Cases:**
- [x] ✅ Login với credentials đúng
- [x] ✅ Login với credentials sai (error message)
- [x] ✅ Register user mới
- [x] ✅ Register với email trùng (validation error)
- [x] ✅ Logout thành công
- [x] ✅ Middleware chặn khi chưa login
- [x] ✅ Session persistent với Remember Me
- [x] ✅ Navbar hiển thị user name

---

## 📝 Notes

### Password trong production

**QUAN TRỌNG:** Đổi password mặc định `123456` trước khi deploy!

```php
// DEVELOPMENT
'password' => Hash::make('123456')

// PRODUCTION
'password' => Hash::make(env('ADMIN_PASSWORD', 'secure-random-password'))
```

### Session Storage

Hiện tại dùng **database sessions**:
```env
SESSION_DRIVER=database
```

**Table:** `sessions`
```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL
);
```

### Laravel Breeze Alternative

Nếu muốn hệ thống auth đầy đủ hơn, có thể dùng Laravel Breeze:
```bash
composer require laravel/breeze --dev
php artisan breeze:install
```

Nhưng với requirements hiện tại, implementation thủ công này đã đủ!

---

## 🎯 Kết luận

Đã implement **đầy đủ hệ thống Login/Logout/Register** với:
- ✅ Security tốt (password hashing, CSRF, session regeneration)
- ✅ UI/UX thân thiện (alerts, validation errors, dropdown)
- ✅ Code clean và maintainable
- ✅ Ready for production deployment

**Test Credentials:**
- Email: `admin@example.com`
- Password: `123456`

**Live Demo:** http://localhost:8000/admin/user/login

---

**Tạo bởi:** Nguyễn Văn Bằng  
**Ngày:** 18/10/2025  
**Sprint:** Sprint 8 - Authentication System
