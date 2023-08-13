@extends('layouts.admin')

@section('title', 'Edit Target')

{{-- @dd($renstradept); --}}

@section('csslocal')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<div class="container">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container mt-3 mb-2">
                <form action="{{ route('target.update', "0".$target->kode )}}" method="post" >
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Strategi</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control bg-light" name="strategi" id="strategi"  value="{{ old('strategi', $target->strategi) }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Indikator Kinerja</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control bg-light" id="indikator_kinerja" name="indikator_kinerja" value="{{ old('indikator_kinerja', $target->indikator_kinerja) }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Definisi</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control bg-light" id= "definisi" name="definisi" placeholder="Definisi" value="{{ old('definisi', $target->definisi) }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Cara Perhitungan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control bg-light" id="cara_perhitungan" name="cara_perhitungan" placeholder="Cara Perhitungan" value="{{ old('cara_perhitungan', $target->cara_perhitungan) }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Satuan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control bg-light" id="satuan" name="satuan" placeholder="Satuan" value="{{ old('satuan', $target->satuan) }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Keterangan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control bg-light" id="keterangan" name="keterangan" placeholder="-" value="{{ old('keterangan', $target->keterangan) }}" readonly>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Tahun</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="tahun" id="date-tahun"placeholder="Tahun" value="{{ old('tahun', $target->tahun) }}">
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Departemen</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="departemen" id="departemen"placeholder="departemen" value="{{ old('departemen', $target->departemen) }}">
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Target*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="target" placeholder="Target" value="{{ old('target', $target->target) }}">
                            @error('target')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group py-3">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus mr-2"></i> Update</button>
                        <a href="{{ route('ptnbh.dashboard') }}" id="back" class="btn btn-light"><i class="fa fa-times mr-2"></i> Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptlocal')

@endsection
