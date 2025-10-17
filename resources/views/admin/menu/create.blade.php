@extends('admin.main')

@section('content')
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header"><div class="card-title">Thêm sản phẩm</div></div>
        <!--end::Header-->
        <!--begin::Form-->
        @include('admin.alert')
        <form action="/admin/menus/store" method="post">
            @csrf
            <!--begin::Body-->
            <div class="card-body">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Thêm sản phẩm</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Giá tiền</label>
                <input type="text" name="price" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label class="form-label">Thêm hình ảnh</label>
                <input type="text" name="image" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <input type="text" name="describe" class="form-control" id="exampleInputPassword1">
            </div>
            <!-- <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
            </div> -->
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
@endsection