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