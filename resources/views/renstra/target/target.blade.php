{{-- @dd($status); --}}

@extends('layouts.admin')

@section('title', ''.$title)

@section('content')
<div class="container" style="margin-top:10px">
  <!-- Page Heading -->
  <section class="content-header">
    <div class="row">
        <div class="col-lg-9" style="display: flex; flex-direction:row;justify-content:space-between;width:100%">
            <h1 class="h3 mb-4 text-primary">@yield('title')</h1>
            @if ($user->level == 0 && $status===2)
                <a href="{{ route('renstra.target.AllAprove', $renstradept )}}" class="btn btn-primary mb-3 px-10"><i class="fa fa-plus mr-2"></i>Setujui Target</a>
            @endif
            {{-- <a href="{{ route('renstra.target.download', $renstradept)}}" class="btn btn-primary">Download PDF Target</a> --}}
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
                                @if ($status===2 && $user->level != 2)
                                    <th>Aksi</th>
                                {{-- @else ()
                                <th>Aksi1</th> --}}
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targets as $target)
                            <tr style="background-color:
                                    @if($target->status=="3")
                                    #e06c6c;color:white; 
                                    @elseif($target->status=="4")
                                    #e0c36c;color:white;
                                    @elseif($target->status=="2")
                                    #e6e6e6; 
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
                                @if($user->level==0)
                                    @if( $target->status == "0" || $target->status == "4")
                                    <form action="{{ route('renstra.target.kirim', $target->kode )}}" method="post" >
                                        <td>
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="target" value="{{ old('target', $target->target) }}"style="width: 45px">
                                                </div>
                                            </div>
                                        </td>
                                        <td style="display:flex;flex-direction:column; justify-content:center ">
                                            <button type="submit" class="btn btn-primary mb-2" >kirim</button>
                                            @if($target->status == "4")
                                                <a class="btn btn-secondary" href="{{ route('renstra.target.batal', $target->kode) }}">Batal</a>
                                            @endif
                                        </td>
                                    </form>
                                    @else
                                        <td>{{ $target->target }}</td>
                                        <td style="display:flex;flex-direction:column; justify-content:center ">
                                        @if($target->status == "1")
                                                <a class="btn mb-2" href="{{ route('renstra.target.batal', $target->kode) }}" style="background-color: #2D7E18;color:white">Disetujui</a>
                                        @elseif($target->status == "2")
                                                <a class="btn btn-primary mb-2" href="{{ route('renstra.target.setujui', $target->kode) }}">Setujui</a>
                                                <a class="btn btn-danger mb-2" href="{{ route('renstra.target.tolak', $target->kode) }}">Tolak</a>
                                                <a class="btn btn-warning" href="{{ route('renstra.target.edit', $target->kode) }}">Edit</a>
                                        @elseif($target->status == "3")
                                                <a class="btn btn-primary mb-2" href="{{ route('renstra.target.setujui', $target->kode) }}">Setujui</a>
                                                <a class="btn btn-warning" href="{{ route('renstra.target.edit', $target->kode) }}">Edit</a>
                                        @endif
                                        </td>
                                    @endif
                                @endif
                                @if($user->level==1)
                                    @if( $target->status == "0" || $target->status == "4")
                                    <form action="{{ route('renstra.target.kirim', $target->kode )}}" method="post" >
                                        <td>
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="target" value="{{ old('target', $target->target) }}" style="width: 45px">
                                                </div>
                                            </div>
                                        </td>
                                        <td style="display:flex;flex-direction:column; justify-content:center ">
                                            <button type="submit" class="btn btn-primary mb-2" >kirim</button>
                                        </td>
                                    </form>
                                    @else
                                        <td>{{ $target->target }}</td>
                                        <td style="display:flex;flex-direction:column; justify-content:center ">
                                            @if($target->status == "1")
                                                <div class="btn" style="background-color: #2D7E18;color:white">Disetujui</div>
                                            @elseif($target->status == "2")
                                                <div class="btn btn-secondary">Menunggu persetujuan</div>
                                            @elseif($target->status == "3")
                                                <a class="btn btn-warning" href="{{ route('renstra.target.edit', $target->kode) }}">Edit</a>
                                            @endif
                                        </td>
                                    @endif
                                @endif
                                @if ($user->level == 2)
                                    @if ($target->target == null)
                                        <td>Belum diatur</td>
                                    @else
                                        <td>{{ $target->target }}</td>
                                    @endif
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $targets->links('pagination.custom') }}
                    
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection