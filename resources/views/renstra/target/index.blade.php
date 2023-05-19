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
        <a href="{{ route('renstra.target.create', $renstradept) }}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i>Tambah Target Baru</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targets as $target)
                            <tr>
                                <th scope="row">{{ $target->kode }}</th>
                                <td>{{  $target->strategi}}</td>
                                <td>{{ $target->indikator_kinerja }}</td>
                                <td>{{ $target->definisi }}</td>
                                <td>{{ $target->cara_perhitungan }}</td>
                                <td>{{ $target->satuan }}</td>
                                @if ($target->keterangan === null)
                                <td>-</td>
                                @else
                                <td>{{ $target->keterangan }}</td>
                                @endif
                                <td>{{ $target->target }}</td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection