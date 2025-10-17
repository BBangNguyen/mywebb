<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Thanh Toán</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    @include('header')

    <div class="container mt-4">
        <h2 class="text-center">Trang Thanh Toán</h2>
        
        <!-- Hiển thị danh sách sản phẩm trong giỏ hàng -->
        <div class="card">
            <div class="card-header">
                <h4>Thông tin đơn hàng</h4>
            </div>
            <div class="card-body">
                @if($cartItems->isNotEmpty())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>{{ $item->product->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->product->product_price, 2) }} VND</td>
                                    <td>{{ number_format($item->product->product_price * $item->quantity, 2) }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4 class="text-end">Tổng tiền: {{ number_format($total, 2) }} VND</h4>
                @else
                    <p>Giỏ hàng của bạn đang trống.</p>
                @endif
            </div>
        </div>

        <!-- Form nhập thông tin giao hàng -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Thông tin giao hàng</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('processCheckout') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Xác nhận thanh toán</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>