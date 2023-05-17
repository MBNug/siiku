@extends('layouts.admin')

@section('title', 'Target Departemen Informatika')

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
        <a href="{{ route('renstra.target.create') }}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i>Tambah Target Baru</a>
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
                            {{-- @foreach($members as $member)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $member->nis }}</td>
                                <td>{{ $member->nama }}</td>
                                <td>{{ $member->alamat }}</td>
                                <td>{{ $member->jmlkunjungan }}</td>
                                <td>{{ $borrows->where('nispeminjam', '=', $member->nis)->count('nispeminjam')}}</td>
                                <td>{{ $borrows->where('nispeminjam', '=', $member->nis)->where('tanggalkembali','=',null)->count('nispeminjam')}}</td>
                                <td>
                                    <a href="{{ route('member.edit', $member->id) }}" class="btn btn-warning btn-sm mt-1" title="Edit Anggota"><i class="fa fa-edit"></i>     Edit</a>
                                    <a data-toggle="modal" id="smallButton" class="btn btn-danger btn-sm mt-1" data-target="#smallModal" data-attr="{{ route('member.delete', $member->id) }}" title="Hapus Anggota">
                                        <i class="fas fa-trash "></i>      Hapus
                                    </a>
                                    <a href="{{ route('member.lihatpinjaman', $member->id) }}" class="btn btn-success btn-sm mt-1" title="Lihat Pinjaman Anggota"><i class="fa fa-file-export"></i>     Pinjaman</a>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection