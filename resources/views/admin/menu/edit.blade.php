@extends('admin.main')
@section('content')
    <div class="container mt-4">
        <h2>{{ $title }}</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="/admin/menu/update/{{ $product->id }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->product_name }}">
                @if($errors->has('name'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ $product->product_price }}">
                @if($errors->has('price'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('price') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="image">Hình ảnh:</label>
                <input type="text" class="form-control" id="image" name="image" value="{{ $product->product_image }}">
                @if($errors->has('image'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('image') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="describe">Mô tả:</label>
                <textarea class="form-control" id="describe" name="describe">{{ $product->product_describe }}</textarea>
                @if($errors->has('describe'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('describe') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection