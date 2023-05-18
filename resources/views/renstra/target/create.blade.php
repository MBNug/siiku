@extends('layouts.admin')

@section('title', 'Tambah Target')

@section('csslocal')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<div class="container">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container mt-3 mb-2">

                <form action="#" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Strategi*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('strategi') is-invalid @enderror" list="strategis" id="strategi" name="strategi" placeholder="Strategi" value="{{ old('strategi') }}">
                            <datalist id="strategis" name="strategi">
                                @foreach ($strategis as $strategi)
                                    <option value="{{ $strategi->nama }}">{{ $strategi->nama }}</option>
                                @endforeach
                            </datalist>
                            @error('strategi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Indikator Kinerja*</label>
                        <div class="col-lg-10">
                            <select name="indikator_kinerja" id="indikator_kinerja" class="form-control @error('indikator_kinerja') is-invalid @enderror" placeholder="Indikator Kinerja" value="{{ old('indikator_kinerja') }}">
                                @foreach ($indikators as $indikator)
                                    <option value="{{ $indikator->kode }}">{{ $indikator->indikator_kinerja }}</option>
                                @endforeach
                            </select>
                            @error('indikator_kinerja')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Definisi</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id= "definisi" name="definisi" placeholder="Definisi" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Cara Perhitungan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="cara_perhitungan" name="cara_perhitungan" placeholder="Cara Perhitungan" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Satuan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Keterangan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Tahun*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="tahun" id="date-tahun"placeholder="Tahun">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Departemen*</label>
                        <div class="col-lg-10">
                            <select name="departemen" id="departemen" class="form-control @error('departemen') is-invalid @enderror" placeholder="Departemen" value="{{ old('departemen') }}">
                                @foreach ($departemens as $departemen)
                                    <option value="{{ $departemen->kode }}">{{ $departemen->nama }}</option>
                                @endforeach
                            </select>
                            
                            @error('departemen')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Target*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="target" placeholder="Target">
                            @error('target')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group py-3">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus mr-2"></i> Tambah</button>
                        <a href="#" id="back" class="btn btn-light"><i class="fa fa-times mr-2"></i> Batal</a>
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
</script>
<script>
    $('#indikator_kinerja').change(function(){
        $.ajax({
            url: '/renstra/indikators/' + $(this).val(),
            type: 'get',
            data: {},
            success: function(data) {
                console.log(data)
                if (data.success == true) {
                    $("#definisi").val(data.definisi);
                    $("#cara_perhitungan").val(data.cara_perhitungan);
                    $("#satuan").val(data.satuan);
                    $("#keterangan").val(data.keterangan);
                } else {
                    alert('Cannot find info');
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:', exception);
            }
        });
    });
</script>

@endsection
