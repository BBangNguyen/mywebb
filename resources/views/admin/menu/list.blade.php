@extends('admin.main')

@section('content')
    <div class="container mt-4">
        <h2>{{ $title }}</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ number_format($product->product_price, 0, ',', '.') }} VND</td>
                        <td><img src="{{ $product->product_image }}" alt="{{ $product->product_name }}" width="100"></td>
                        <td>{{ $product->product_describe }}</td>
                        <td>
                            <a href="/admin/menus/edit/{{$product->id}}" class="btn btn-warning">Sửa</a>
                            <form action="/admin/menus/delete/{{$product->id}}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection