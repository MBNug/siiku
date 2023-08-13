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
                                @if ($realisasi->status === null)
                                    <td>Sedang Diproses</td>
                                @else
                                    <td>{{ $realisasi->status }}</td>
                                @endif
                                <td>
                                    {{-- @dd(
                                        $user->level!=2 && ($realisasi->nilai != null && $realisasi->bukti1 != null)
                                    ) --}}
                                    @if($user->level!=2 && $realisasi->status != null)
                                        <a class="btn mb-2" href="{{ route('renstra.realisasi.show', [$renstradept, $realisasi->kode]) }}" style="background-color: #2D7E18;color:white">
                                            Lihat Data
                                    @elseif ($user->level!=2 && ($realisasi->nilai != null || $realisasi->bukti1 != null))
                                        <a class="btn mb-2" href="{{ route('renstra.realisasi.form', [$renstradept, $realisasi->kode]) }}" style="background-color: #2D7E18;color:white">
                                            Cek Nilai
                                    @elseif($user->level == 2 && $realisasi->status === null)
                                        <a class="btn mb-2" href="{{ route('renstra.realisasi.form', [$renstradept, $realisasi->kode]) }}" style="background-color: #2D7E18;color:white">    
                                            Update Data
                                    @endif
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