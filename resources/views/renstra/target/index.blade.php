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
        @if ($user->level == 1)
            <a href="{{ route('renstra.target.create', $renstradept) }}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i>Tambah Target Baru</a>
        @endif
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
                                @if ($status===2)
                                    <th>Aksi</th>
                                {{-- @else ()
                                <th>Aksi1</th> --}}
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targets as $target)
                            <tr style="background-color:
                                @if($user->level==0)
                                    @if($target->status=="2")
                                        #D14646; 
                                    @elseif($target->status=="3")
                                        #E6E6E6
                                    @endif 
                                @elseif($user->level==1)
                                    @if($target->status=="2")
                                        #D14646; 
                                    @endif 
                                @endif 
                            ">
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
                                @if ($user->level==0 && $status===2)
                                <td>
                                    @if ($target->status=="0" || $target->status=="3")
                                        <a class="btn btn-danger" href="{{ route('renstra.tolak', $target->kode) }}">tolak</a>
                                    @elseif ($target->status=="2")
                                        <a class="btn btn-warning" href="{{ route('renstra.urungkan', $target->kode) }}">urungkan</a>
                                    @endif
                                </td>
                                @endif
                                @if ($user->level==1 && $status===2)
                                <td>
                                    @if ($target->status=="2")
                                        <a class="btn btn-warning" href="#">Edit</a>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($user->level == 0 && $status===2)
                        <a href="#" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i>Setujui Target</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection