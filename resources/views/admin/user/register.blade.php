@include('admin.header');
  <body class="register-page bg-body-secondary">
    <div class="register-box">
      <div class="register-logo">
        <a href="#!"><b>Admin</b> Register</a>
      </div>
      <!-- /.register-logo -->
      <div class="card">
        <div class="card-body register-card-body">
          <p class="register-box-msg">Đăng ký tài khoản mới</p>
            @include('admin.alert')
          <form action="{{ route('register.store') }}" method="post">
          @csrf
            <div class="input-group mb-3">
              <input type="text" name="name" class="form-control" placeholder="Họ và tên" value="{{ old('name') }}" required />
              <div class="input-group-text"><span class="bi bi-person"></span></div>
            </div>
            @error('name')
              <div class="text-danger mb-2">{{ $message }}</div>
            @enderror

            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required />
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
            @error('email')
              <div class="text-danger mb-2">{{ $message }}</div>
            @enderror

            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            @error('password')
              <div class="text-danger mb-2">{{ $message }}</div>
            @enderror

            <div class="input-group mb-3">
              <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Đăng ký</button>
                </div>
              </div>
            </div>
          </form>

          <p class="mt-3 mb-1">
            <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập</a>
          </p>
        </div>
      </div>
    </div>
    @include('admin.footer');
    </body>
