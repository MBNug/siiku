@extends('layouts.admin')

@section('title', 'Target Departemen Informatika')

@section('content')
    <div id="dashboard">
        <div class="row">
            <div class="col">
                <div class="container">Jumlah Target yang telah disetujui</div>
            </div>
            <div class="col"><div class="container">Jumlah Target yang menunggu persetujuan</div></div>
            <div class="col"><div class="container">JUmlah Target yang ditolak</div></div>
        </div>
        <div class="row">
            <div class="col"><div class="container">presentase ketercapaian target</div></div>
        </div>
        @if ($user->level==1)
        <div class="row">
            <div class="col"><div class="container">jumlah departemen yang telah selesai</div></div>
            <div class="col"><div class="container">jumlah realisasi yang sudah dicek</div></div>
            <div class="col"><div class="container">jumlah realisasi yang belum dicek</div></div>
        </div>
        @endif
    </div>
@endsection