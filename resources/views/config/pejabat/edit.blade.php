@extends('layouts.admin')

@section('title', 'Tambah Target')

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
                
                <form action="{{ route('pejabat.update', $pejabat->kode)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Departemen*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control bg-light" name="departemen" id="departemen"  value="{{ old('departemen', $pejabat->departemen) }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Jabatan*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control bg-light" name="jabatan" id="jabatan"  value="{{ old('jabatan', $pejabat->jabatan) }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Nama*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Nama" value="{{ old('nama', $pejabat->nama) }}">
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">NIP*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" placeholder="NIP" value="{{ old('nip', $pejabat->nip) }}">
                            @error('nip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Tanda Tangan*</label>
                        <div class="col-lg-10">
                            <input type="file" accept=".png" class="form-control @error('tandatangan') is-invalid @enderror" name="tandatangan" placeholder="Tanda Tangan" value="{{ old('tandatangan', $pejabat->tandatangan) }}">
                            @error('tandatangan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group py-3">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus mr-2"></i> Simpan</button>
                        <a href="{{ route('pejabat.index') }}" id="back" class="btn btn-light"><i class="fa fa-times mr-2"></i> Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptlocal')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $('#date-tahun').datepicker({
        minViewMode: "years",
        format: "yyyy",
        viewMode: "years",
        autoclose: true
    });

    $('#departemen').change(function(){
        // Empty the dropdown
        $('#jabatan').find('option').not(':first').remove();
        $dept = $(this).val();
        if($dept == '00'){
            var option = new Option('Dekan', '00');
            $("#jabatan").append($(option));
            var option = new Option('Wakil Dekan 1', '01');
            $("#jabatan").append($(option));
            var option = new Option('Wakil Dekan 2', '02');
            $("#jabatan").append($(option));
            var option = new Option('Wakil Dekan 3', '03');
            $("#jabatan").append($(option));
            var option = new Option('Wakil Dekan 4', '04');
            $("#jabatan").append($(option));
            var option = new Option('Admin Operator Fakultas', '99');
            $("#jabatan").append($(option));
        }
        else{
            var option = new Option('Kepala Departemen', '01');
            $("#jabatan").append($(option));
            var option = new Option('Admin Operator Departemen', '99');
            $("#jabatan").append($(option));
        }
    });
</script>


@endsection