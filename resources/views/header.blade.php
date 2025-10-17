<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Shopping Cart</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="{{ route('products.index') }}" class="navbar-brand">
            <h3 class="px-5">
                <i class="fas fa-shopping-basket"></i> Happy Store
            </h3>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="mr-auto"></div>
            <div class="navbar-nav">
                <form action="{{ route('search') }}" method="GET" class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search" name="query">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
                </form>
                @php $cartCount = $totalQuantity ?? session('cart_count', 0); @endphp
                <a href="{{ route('cart.index') }}" class="nav-item nav-link active">
                    <h5 class="px-5 cart">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                        <span id="cart_count" class="text-warning bg-light px-2 rounded">{{ $cartCount }}</span>
                    </h5>
                </a>
            </div>
        </div>
    </nav>
</header>

</body>
</html>