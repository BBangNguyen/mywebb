<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <link rel="stylesheet" href="{{ asset('./css/style.css') }}">
</head>
<body>
    @include('header')

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    <div class="container">
        <div class="row text-center py-5">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6 my-3 my-md-0" >
                    <form action="{{ route('cart.add') }}" method="post">
                        @csrf
                        <div class="card shadow">
                            <div>
                                <img src="{{ $product->product_image }}" alt="{{ $product->product_name }}" class="img-fluid card-img-top" style="width: 100%; height: 245px;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <h6>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </h6>
                                <p class="card-text">{{ $product->product_describe }}</p>
                                <h5>
                                    <small><s class="text-secondary">{{ number_format(500000, 0, ',', '.') }}đ</s></small>
                                    <span class="price">{{ number_format($product->product_price, 0, ',', '.') }}đ</span>
                                </h5>
                                <button type="submit" class="btn btn-warning my-3" name="add">Thêm vào giỏ hàng <i class="fas fa-shopping-cart"></i></button>
                                <input type='hidden' name='product_id' value='{{ $product->id }}'>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>