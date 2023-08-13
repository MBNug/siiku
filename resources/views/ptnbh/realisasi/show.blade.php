@extends('layouts.admin')

@section('title', $title)

@section('csslocal')
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="container">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-9">
                <h1 class="h3 mb-4 text-primary">@yield('title')</h1>
            </div>
        </div>
    </section>
    <div class="card shadow mb-4">
        <div class="container mt-3 mb-2">
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Strategi</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->strategi }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Indikator Kinerja</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->indikator_kinerja }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Definisi</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->definisi }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Cara Perhitungan</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->cara_perhitungan }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Satuan</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->satuan }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Keterangan</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">@if ($realisasi->keterangan === null)
                        -
                        @else
                        {{ $realisasi->keterangan }}
                        @endif</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Target</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->target }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Nilai</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->nilai }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Bukti</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                        
                </div>
                <div class="col-8">
                    {{-- @dd($files) --}}
                    @foreach ($files as $file)
                        
                        @if ($file)
                            <div class="col-8">
                                <li class="list-group-item px-2">
                                    <a href="{{ Storage::url($file) }}" target="_blank"> {{ basename($file) }}</a>
                                </li>
                            </div>
                                
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Status</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->status }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <p class="fw-bold text-primary">Nilai Realisasi</p>
                </div>
                <div class="col-1">
                    <p class="fw-bold text-primary ps-5 ms-5">: </p>
                </div>
                <div class="col-8">
                    <p class="fw-bold text-primary">{{ $realisasi->nilaireal }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <a class="btn mb-2" href="{{ route('renstra.realisasi.form', [$departemen->kode, $realisasi->kode]) }}" style="background-color: #17356d;color:white"><i class="fa-solid fa-pen-to-square"></i>
                        Edit Nilai Realisasi </a>
                </div>
            </div>
            
        </div>
    
    </div>
</div>

@endsection
