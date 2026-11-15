<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login SIIKU</title>

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/0ba61acd0d.js" crossorigin="anonymous"></script>
    
  <!-- Bootstrap -->
  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="login-page">
    {{-- <div class="container"> --}}
        <div class="row">
            <div class="col" id="login-img">
                <img src="https://pelajarinfo.id/wp-content/uploads/2021/06/Universitas-Diponegoro-Semarang-Logo.png" alt="Logo Undip">
            </div>
            <div class="col" id="login-side">
                <div class="container" id="login-container">
                    <img src="https://pelajarinfo.id/wp-content/uploads/2021/06/Universitas-Diponegoro-Semarang-Logo.png" alt="Logo Undip" id="responsive-logo">
                    <h2 id="text-login">LOGIN</h2>
                    <form action="{{ url('login/proses') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input autofocus type="text" class="form-control
                            @error('username')
                                is-invalid
                            @enderror
                            " placeholder="username" name="username" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control
                            @error('password')
                                is-invalid
                            @enderror
                            " placeholder="Password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block btn-login">LOGIN</button>
                            </div>
                        </div>
                    </form>
                    @if (config('app.demo_mode') && config('app.demo_login_password'))
                        <div class="alert alert-info mt-3 mb-0 small text-start">
                            <div class="fw-bold mb-1">Akun Demo</div>
                            <div>Admin Fakultas: <code>admin</code></div>
                            <div>Dekan (Approval): <code>dekan</code></div>
                            <div>Departemen: <code>adminMatematika</code></div>
                            <div class="mt-1">Password semua akun: <code>{{ config('app.demo_login_password') }}</code></div>
                            <div class="text-muted mt-1">Database di-reset otomatis setiap hari pukul 03:00 WIB.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    {{-- </div> --}}


<!-- jQuery -->
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/') }}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/') }}dist/js/adminlte.min.js"></script>
</body>
</html>