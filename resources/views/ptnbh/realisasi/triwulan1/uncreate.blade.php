@extends('layouts.admin')

@section('title', ''.$title)

@section('csslocal')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<div class="container" style="height: 100vh;margin-top:30px;">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body"style="height: 80vh;display: flex;
        flex-direction: column;justify-content:center;align-items:center;" >
            <h4 style="text-align:center;margin:30px;">@yield('title') belum tersedia, Silahkan buat data Realisasi dengan mengklik tombol dibawah.</h4>
            <a href="{{ route('ptnbh.realisasi.store', [$ptnbhdept, $triwulan->triwulan]) }}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i> Buat @yield('title') </a>
        </div>
    </div>
</div>
@endsection



