
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    @include('admin.header')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container--> 
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a href="#" class="dropdown-item">
                  <i class="bi bi-person me-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                  </button>
                </form>
              </div>
            </li>
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      @include('admin.sidebar')
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Admin page</h3></div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                <!-- Default box -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                @yield('content')
            </div>
            <!--end::Row-->
          </div>
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2024&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    @include('admin.footer')
  </body>
  <!--end::Body-->
</html>

