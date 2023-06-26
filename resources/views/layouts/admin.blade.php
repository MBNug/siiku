<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/0ba61acd0d.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    
    @yield('csslocal')
    
    

</head>

<body>
  <div class="main-container d-flex">
    <div class="sidebar" id="side_nav">
      <div class="header-box d-flex justify-content-between">
        <a href="{{ route('renstra.dashboard') }}" class="d-flex align-items-center px-3 pt-3 pb-2 mb-3 text-decoration-none text-white">
          <img class="bi me-2" width="30" height="24" src="img/undip.png">
          <span class="fs-5 fw-semibold">SI-IKU</span>
          <button class="btn d-md-none d-block close-btn px-1 py-0 text-white"><i class="fa-solid fa-bars-staggered"></i></button>
        </a>
      </div>

      <ul class="list-unstyled ps-0">
        <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#renstra-collapse" aria-expanded="{{ Request::is('renstra*') ? 'true' : 'false' }}">
            Renstra
          </button>
          <div class="collapse {{ Request::is('renstra*') ? 'show' : '' }}" id="renstra-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="{{ route('renstra.dashboard') }}" class="{{ Request::is('renstra/dashboard') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('renstra/dashboard') ? 
                'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Dashboard</a></li>
              <li><a href="{{ route('renstra.target.index') }}" class="{{ Request::is('renstra/target') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('renstra/target') ? 
                'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Target</a></li>
              <li><a href="#" class="{{ Request::is('renstra/realisasi') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('renstra/realisasi') ? 
                'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Realisasi</a></li>
              {{-- <li class="mb-1">
                <a class="align-items-center text-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#renstratarget-collapse" aria-expanded="false">Target</a>
                <div class="collapse" id="renstratarget-collapse">
                  <ul class="btn-toggle-nav list-unstyled fw-normal px-3 pb-1 small">
                    @foreach ($departemens as $departemen)
                      <li><a href="{{ route('renstra.target.index', $departemen->kode) }}" class="link-dark rounded">{{ $departemen->nama }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </li>
              <li class="mb-1">
                <a class="align-items-center text-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#renstrarealisasi-collapse" aria-expanded="false">Realisasi</a>
                <div class="collapse" id="renstrarealisasi-collapse">
                  <ul class="btn-toggle-nav list-unstyled fw-normal px-3 pb-1 small">
                    <li><a href="#" class="link-dark rounded">Matematika</a></li>
                    <li><a href="#" class="link-dark rounded">Biologi</a></li>
                    <li><a href="#" class="link-dark rounded">Kimia</a></li>
                    <li><a href="#" class="link-dark rounded">Fisika</a></li>
                    <li><a href="#" class="link-dark rounded">Statistika</a></li>
                    <li><a href="#" class="link-dark rounded">Informatika</a></li>
                  </ul>
                </div>
              </li> --}}
            </ul>
          </div>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#ptnbh-collapse" aria-expanded="{{ Request::is('ptnbh/dashboard')||Request::is('ptnbh/target')||Request::is('ptnbh/realisasi') ? 'true' : 'false' }}">
            PTN-BH
          </button>
          <div class="collapse {{ Request::is('ptnbh*') ? 'show' : '' }}" id="ptnbh-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="{{ route('renstra.dashboard') }}" class="{{ Request::is('ptnbh/dashboard') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('ptnbh/dashboard') ? 
                'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Dashboard</a></li>
              <li><a href="#" class="{{ Request::is('ptnbh/target') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('ptnbh/target') ? 
                'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Target</a></li>
              <li><a href="#" class="{{ Request::is('ptnbh/realisasi') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('ptnbh/realisasi') ? 
                'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Realisasi</a></li>
              {{-- <li class="mb-1">
                <a class="align-items-center text-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#ptnbhtarget-collapse" aria-expanded="false">Target</a>
                <div class="collapse" id="ptnbhtarget-collapse">
                  <ul class="btn-toggle-nav list-unstyled fw-normal px-3 pb-1 small">
                    <li><a href="#" class="link-dark rounded">Matematika</a></li>
                    <li><a href="#" class="link-dark rounded">Biologi</a></li>
                    <li><a href="#" class="link-dark rounded">Kimia</a></li>
                    <li><a href="#" class="link-dark rounded">Fisika</a></li>
                    <li><a href="#" class="link-dark rounded">Statistika</a></li>
                    <li><a href="#" class="link-dark rounded">Informatika</a></li>
                  </ul>
                </div>
              </li>
              <li class="mb-1">
                <a class="align-items-center text-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#ptnbhrealisasi-collapse" aria-expanded="false">Realisasi</a>
                <div class="collapse" id="ptnbhrealisasi-collapse">
                  <ul class="btn-toggle-nav list-unstyled fw-normal px-3 pb-1 small">
                    <li><a href="#" class="link-dark rounded">Matematika</a></li>
                    <li><a href="#" class="link-dark rounded">Biologi</a></li>
                    <li><a href="#" class="link-dark rounded">Kimia</a></li>
                    <li><a href="#" class="link-dark rounded">Fisika</a></li>
                    <li><a href="#" class="link-dark rounded">Statistika</a></li>
                    <li><a href="#" class="link-dark rounded">Informatika</a></li>
                  </ul>
                </div>
              </li> --}}
            </ul>
          </div>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#config-collapse" aria-expanded="{{ Request::is('config/tahun') ? 'true' : 'false' }}">
            Config
          </button>
          <div class="collapse {{ Request::is('config*') ? 'show' : '' }}" id="config-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="{{ route('config.index') }}" class="{{ Request::is('config/tahun') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('config/tahun') ? 
              'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Tahun</a></li>
              <li><a href="{{ route('pejabat.index') }}" class="{{ Request::is('config/pejabat') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('config/pejabat') ? 
                'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Pejabat</a></li>
              <li><a href="{{ route('departemen.index') }}" class="{{ Request::is('config/departemen') ? 'rounded' : 'link-dark rounded' }}" style="{{ Request::is('config/departemen') ? 
                'background-color: #fff; font-weight: 500; color: #000;' : ''}}">Departemen</a></li>
            </ul>
          </div>
        </li>
      </ul>

      <hr class="h-color mx-2">

      <ul class="btn-toggle-nav list-unstyled fw-normal" style="margin-left: -10px;">
        <li>
          <a href="{{ url('logout') }}" class="text-decoration-none link-dark rounded"><i class="fa-solid fa-right-from-bracket px-2"></i>Logout</a>
        </li>
      </ul>

    </div>
    <div class="content">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
          <div class="d-flex justify-content-between d-md-none d-block">
            <a class="navbar-brand" href="{{ route('renstra.dashboard') }}">SI-IKU</a>
            <button class="btn px-1 py-0 open-btn"><i class="fa-solid fa-bars-staggered"></i></button>
          </div>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                  <img class="img-profile rounded-circle" height="30" src="https://ui-avatars.com/api/?name={{ $user->name }}">
                  <span class="ml-2 d-none d-lg-inline text-gray-600 small">{{ $user->name }}</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End of Navbar -->
      <!-- Page Content -->
      @yield('content')
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/jquery.js') }}"></script>
  <script src="{{ asset('assets/jquery-ui.js') }}"></script>
  <script src="{{ asset('assets/bootstrap.js') }}"></script>
  @include('sweetalert::alert')

  <!-- JS Sidebar Navbar-->
  <script>
    $(".sidebar ul li").on('click', function(){
      $(".sidebar ul li.active").removeClass('active');
      $(this).addClass('active');
    });
    $(".open-btn").on('click', function(){
      $(".sidebar").addClass('active');
      });
    $(".close-btn").on('click', function(){
      $(".sidebar").removeClass('active');
    });
  </script>

  @yield('scriptlocal')
    
</body>

</html>
