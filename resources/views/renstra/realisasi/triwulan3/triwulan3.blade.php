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
        <div class="col-6">
            <a class="btn" href="{{ route('renstra.realisasidepartemen', [$renstradept, '1']) }}" style="background-color: white;color:#17356d">Triwulan 1</a>
            <a class="btn" href="{{ route('renstra.realisasidepartemen', [$renstradept, '2']) }}" style="background-color: white;color:#17356d">Triwulan 2</a>
            <a class="btn" href="{{ route('renstra.realisasidepartemen', [$renstradept, '3']) }}" style="background-color: #17356d;color:white">Triwulan 3</a>
            <a class="btn" href="{{ route('renstra.realisasidepartemen', [$renstradept, '4']) }}" style="background-color: white;color:#17356d">Triwulan 4</a>
        </div>
        <div class="col-2"></div>
        @if ($user->level != 2 && $actTri->triwulan == '3')
        <div class="col-4">
            <a class="btn" href="{{ route('renstra.realisasi.alertakhiritriwulan', [$renstradept, $triwulan->triwulan]) }}" style="background-color: #17356d;color:white">Akhiri Triwulan 3</a>
            <a href="{{ route('renstra.realisasi.download', [$renstradept, $triwulan->triwulan])}}" class="btn btn-primary">Download PDF Triwulan 3</a>
        </div>
        @else
        <div class="col-1"></div>
        <div class="col-3">
            <a href="{{ route('renstra.realisasi.download', [$renstradept, $triwulan->triwulan])}}" class="btn btn-primary">Download PDF Triwulan 3</a>
        </div>
        @endif
        
        
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
                                    {{-- @dd(
                                        $user->level!=2 && ($realisasi->nilai != null && $realisasi->bukti1 != null)
                                    ) --}}
                                    @if($user->level!=2 && $realisasi->status != 'Belum Diupdate' && $realisasi->status != 'Sedang Diproses' )
                                        <a class="btn mb-2" href="{{ route('renstra.realisasi.show', [$renstradept, $triwulan->triwulan, $realisasi->kode]) }}" style="background-color: #2D7E18;color:white">
                                            Lihat Data
                                    @elseif ($user->level!=2 && $realisasi->status != 'Belum Diupdate' && $realisasi->bukti1 != null)
                                        <a class="btn mb-2" href="{{ route('renstra.realisasi.form', [$renstradept, $triwulan->triwulan, $realisasi->kode]) }}" style="background-color: #2D7E18;color:white">
                                            Cek Nilai
                                    @elseif($user->level == 2 && ($realisasi->status === 'Belum Diupdate' || $realisasi->status === 'Sedang Diproses' ))
                                        <a class="btn mb-2" href="{{ route('renstra.realisasi.form', [$renstradept, $triwulan->triwulan, $realisasi->kode]) }}" style="background-color: #2D7E18;color:white">    
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