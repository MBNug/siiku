@extends('layouts.admin')

@section('title', 'Tambah Departemen')

{{-- @dd($renstradept); --}}

@section('csslocal')

@endsection

@section('content')
<div class="container">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container mt-3 mb-2">
                
                <form action="{{ route('departemen.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Kode*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" placeholder="Kode" value="{{ old('kode') }}">
                            @error('kode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Nama*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Nama" value="{{ old('nama') }}">
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group py-3">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus mr-2"></i> Tambah</button>
                        <a href="{{ route('departemen.index') }}" id="back" class="btn btn-light"><i class="fa fa-times mr-2"></i> Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptlocal')



@endsection
