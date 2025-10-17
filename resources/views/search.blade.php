<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    @include('header')

    <div class="container mt-5">
        <h2 class="text-center mb-4">Kết quả tìm kiếm cho: "{{ request()->input('query') }}"</h2>
        <div class="row">
            @if($products->isEmpty())
                <div class="col-12">
                    <h5 class="text-center">Không tìm thấy sản phẩm nào.</h5>
                </div>
            @else
                @foreach($products as $product)
                    <div class="col-md-3 col-sm-6 my-3">
                        <div class="card shadow-sm">
                            <img src="{{ $product->product_image }}" alt="{{ $product->product_name }}" class="img-fluid card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <h6 class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </h6>
                                <p class="card-text">{{ $product->product_describe }}</p>
                                <h5>
                                    <small><s class="text-secondary">5000000đ</s></small>
                                    <span class="price">{{ $product->product_price }}đ</span>
                                </h5>
                                <form action="{{ route('cart.add') }}" method="post">
                                    @csrf
                                    <input type='hidden' name='product_id' value='{{ $product->id }}'>
                                    <button type="submit" class="btn btn-warning my-3" name="add">Thêm vào giỏ hàng <i class="fas fa-shopping-cart"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>