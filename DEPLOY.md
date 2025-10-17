# 🚀 HƯỚNG DẪN DEPLOY LÊN RAILWAY (MIỄN PHÍ)

## Bước 1: Đăng ký Railway
1. Truy cập: https://railway.app
2. Click **"Login"** → **"Login with GitHub"**
3. Cho phép Railway truy cập GitHub của bạn

## Bước 2: Tạo Project mới
1. Click **"New Project"**
2. Chọn **"Deploy from GitHub repo"**
3. Chọn repository: **BBangNguyen/mywebb**
4. Railway sẽ tự động detect Laravel và bắt đầu build

## Bước 3: Thêm Environment Variables
Sau khi project được tạo, click vào project → Tab **"Variables"**:

Thêm các biến sau:

```
APP_NAME=Laravel Shopping Cart
APP_ENV=production
APP_KEY=base64:7xXX9y9JeE9myXdN8qOgWwkKvsnASk6OVyFfWR8CqqU=
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

DB_CONNECTION=mysql
DB_HOST=mysql-3d5620ea-bangnguyen-aiven.b.aivencloud.com
DB_PORT=10173
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=<LẤY TỪ AIVEN CONSOLE>
MYSQL_ATTR_SSL_CA=

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error
```

**Lưu ý:** 
- Copy `DB_PASSWORD` từ Aiven Console → MySQL service → Connection information
- Không commit password vào Git!

## Bước 4: Generate Domain
1. Trong project settings, tìm **"Public Networking"**
2. Click **"Generate Domain"**
3. Railway sẽ tạo domain dạng: `your-app-name.up.railway.app`
4. Copy domain này và cập nhật vào biến `APP_URL`

## Bước 5: Run Migrations
1. Vào tab **"Deployments"**
2. Chọn deployment mới nhất
3. Kiểm tra logs để đảm bảo migration đã chạy

✅ **XONG!** Website của bạn đã live tại: `https://your-app-name.up.railway.app`

---

## 💰 Chi phí
- **$5 miễn phí/tháng** (khoảng 500 giờ chạy)
- Đủ cho testing/demo
- Không cần thẻ tín dụng

## ⚠️ Lưu ý
- Railway sẽ sleep app sau 1 giờ không hoạt động (free tier)
- Lần đầu truy cập sẽ hơi chậm (5-10s để wake up)
- Database dùng Aiven nên không bị mất data

## 🔧 Nếu có lỗi
1. Check logs trong Railway dashboard
2. Đảm bảo APP_KEY đã được set
3. Kiểm tra database connection trong Aiven Console
