{{-- @dd($status); --}}

@extends('layouts.admin')

@section('title', ''.$title)

@section('content')
<div class="container">
  <!-- Page Heading -->
  <section class="content-header">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="h3 mb-4 text-primary">@yield('title')</h1>
        </div>
    </div>
  </section>
  <div class="row">
    <div class="row">
        <div class="col-9">
        </div>
        <div class="col-3">
            <a href="{{ route('renstra.realisasi.download', [$renstradept, $triwulan->triwulan])}}" class="btn btn-primary">Download PDF Realisasi</a>
        </div>
        
    </div>
    <div class="col-lg">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th scope="col">kode</th>
                                <th>Strategi</th>
                                <th>Indikator Kinerja</th>
                                <th>Definisi</th>
                                <th>Cara Perhitungan</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                                <th>Target</th>
                                <th>Status Realisasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($realisasis as $realisasi)
                            <tr>
                                <th scope="row">{{ $realisasi->kode }}</th>
                                <td>{{  $realisasi->strategi}}</td>
                                <td>{{ $realisasi->indikator_kinerja }}</td>
                                <td>{{ $realisasi->definisi }}</td>
                                <td>{{ $realisasi->cara_perhitungan }}</td>
                                <td>{{ $realisasi->satuan }}</td>
                                @if ($realisasi->keterangan === null)
                                    <td>-</td>
                                @else
                                    <td>{{ $realisasi->keterangan }}</td>
                                @endif
                                <td>{{ $realisasi->target }}</td>
                                <td>{{ $realisasi->status }}</td>
                                <td>
                                    <a class="btn mb-2" href="{{ route('renstra.realisasi.show', [$renstradept, $triwulan->triwulan, $realisasi->kode]) }}" style="background-color: #2D7E18;color:white">
                                            Lihat Data
                                    </a>
                                </td>
                                
                            </tr>
                            @endforeach
                    </table>
                    {{ $realisasis->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection