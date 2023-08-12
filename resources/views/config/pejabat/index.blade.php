{{-- @dd($status); --}}

@extends('layouts.admin')

@section('title', 'Data Pejabat Fakultas Sains dan Matematika')

@section('content')
<div class="container">
  <!-- Page Heading -->
  <section class="content-header">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="h3 mb-4 text-primary">Data Pejabat Fakultas Sains dan Matematika</h1>
        </div>
    </div>
  </section>
  <div class="row">
    <div class="col-lg">
        @if ($user->level == 1)
            <a href="{{ route('pejabat.create') }}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i>Tambah Pejabat Baru</a>
        @endif
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th scope="col">Kode</th>
                                <th>Departemen</th>
                                <th>Jabatan</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                {{-- <th>Tanda Tangan</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pejabats as $pejabat)
                            {{-- @dd($pejabat) --}}
                            <tr>
                                <th scope="row">{{ $pejabat->kode }} </th>
                                <td>{{ $pejabat->departemen}}</td>
                                <td>{{ $pejabat->jabatan }}</td>
                                <td>{{ $pejabat->nama }}</td>
                                <td>{{ $pejabat->nip }}</td>
                                {{-- <td><img src="{{ asset($pejabat->tandatangan) }}" alt="Tanda Tangan"></td> --}}
                                @if ($user->level==1)
                                <td>
                                    <a class="btn btn-warning" href="{{ route('pejabat.edit',$pejabat->kode) }}">Edit</a>
                                </td>
                                @endif
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