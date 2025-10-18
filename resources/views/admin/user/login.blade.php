@include('admin.header');
  <body class="login-page bg-body-secondary">
    <div class="login-box">
      <div class="login-logo">
        <a href="#!"><b>Admin</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
            @include('admin.alert')
          <form action="/admin/user/login/store" method="post">
          @csrf
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required />
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
            @error('email')
              <div class="text-danger mb-2">{{ $message }}</div>
            @enderror

            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            @error('password')
              <div class="text-danger mb-2">{{ $message }}</div>
            @enderror
            <!--begin::Row-->
            <div class="row">
              <div class="col-8">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" value="" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </form>

          <p class="mt-3 mb-1">
            <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký ngay</a>
          </p>
        </div>
      </div>
    </div>
    @include('admin.footer');
    </body>
