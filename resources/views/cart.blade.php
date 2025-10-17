<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Store</title>
    <link rel="stylesheet" href="{{ asset('./css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .shopping-cart {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .cart-item {
            margin-bottom: 20px;
        }
        .cart-item img {
            max-width: 100%;
            border-radius: 10px;
        }
        .price-details {
            font-size: 16px;
        }
        .price-details h6 {
            margin: 0;
        }
    </style>
</head>
<body class="bg-light">

@include('header')

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="shopping-cart">
                <h6>Giỏ hàng của tôi</h6>
                <hr>

                @if($cartItems->isNotEmpty())
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ $item->product->product_image }}" alt="{{ $item->product->product_name }}" class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <h5 class="pt-2">{{ $item->product->product_name }}</h5>
                                    <small class="text-secondary">{{ $item->product->product_describe }}</small>
                                    <h5 class="pt-2">{{ number_format($item->product->product_price, 0, ',', '.') }} VND</h5>
                                    <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        <button type="submit" class="btn btn-danger mx-2">Xóa</button>
                                    </form>
                                </div>
                                <div class="col-md-3 py-5">
                                    <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn bg-light border rounded-circle" name="decrease_quantity"><i class="fas fa-minus"></i></button>
                                        <input type="text" value="{{ $item->quantity }}" class="form-control w-25 d-inline" readonly>
                                        <button type="submit" class="btn bg-light border rounded-circle" name="increase_quantity"><i class="fas fa-plus"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5>Giỏ hàng trống</h5>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="border rounded mt-5 bg-white h-100 p-4">
                <h6>Thanh toán</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <h6>Giá tiền ({{ $cartItems->sum('quantity') }} sản phẩm)</h6>
                        <h6>Phí vận chuyển</h6>
                        <hr>
                        <h6>Tổng tiền</h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <h6>{{ number_format($total, 0, ',', '.') }} VND</h6>
                        <h6 class="text-success">Miễn phí</h6>
                        <hr>
                        <h6>{{ number_format($total, 0, ',', '.') }} VND</h6>
                    </div>
                </div>
                <form action="{{ route('checkout') }}" method="GET">
                    <button type="submit" class="btn btn-primary w-100 mt-3">Thanh toán</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>