<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Laravel Shopping Cart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        
        .left-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .left-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .left-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.9;
        }
        
        .right-section {
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
        }
        
        .welcome-title {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }
        
        .welcome-title h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .welcome-title p {
            color: #666;
            font-size: 0.95rem;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .btn {
            padding: 16px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: block;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        .btn-register {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-register:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .features {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            color: #555;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
            
            .left-section {
                padding: 40px 30px;
            }
            
            .left-section h1 {
                font-size: 2rem;
            }
            
            .right-section {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <h1>🛒 Laravel Shopping Cart</h1>
            <p>
                Hệ thống quản lý bán hàng trực tuyến hiện đại với Laravel 11. 
                Trải nghiệm mua sắm trực tuyến mượt mà với giỏ hàng thông minh, 
                thanh toán nhanh chóng và quản lý đơn hàng chuyên nghiệp.
            </p>
            <div style="margin-top: 30px; opacity: 0.8;">
                <p>✨ <strong>Công nghệ:</strong> Laravel 11, MySQL, Railway</p>
                <p>🚀 <strong>Tính năng:</strong> Cart, Checkout, Admin Panel</p>
                <p>🔒 <strong>Bảo mật:</strong> HTTPS, Session, CSRF Protection</p>
            </div>
        </div>
        
        <div class="right-section">
            <div class="welcome-title">
                <h2>Chào mừng! 👋</h2>
                <p>Đăng nhập để quản lý cửa hàng hoặc đăng ký tài khoản mới</p>
            </div>
            
            <div class="btn-group">
                <a href="{{ route('login') }}" class="btn btn-login">
                    🔐 Đăng nhập
                </a>
                <a href="{{ route('register') }}" class="btn btn-register">
                    ✍️ Đăng ký tài khoản
                </a>
            </div>
            
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">🛍️</div>
                    <div>
                        <strong>12+ Sản phẩm</strong><br>
                        <small>Đa dạng danh mục điện tử</small>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🎯</div>
                    <div>
                        <strong>Admin Panel</strong><br>
                        <small>Quản lý sản phẩm dễ dàng</small>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⚡</div>
                    <div>
                        <strong>Real-time Cart</strong><br>
                        <small>Cập nhật giỏ hàng tức thì</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
