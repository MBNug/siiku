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
                
                <form action="{{ route('renstra.target.store', $renstradept )}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Strategi*</label>
                        <div class="col-lg-10">
                            <select name="strategi" id="strategi" class="form-control @error('strategi') is-invalid @enderror" placeholder="Strategi" value="{{ old('strategi') }}" required>
                                <option value="">-- Pilih Strategi --</option>
                                @foreach ($strategis as $strategi)
                                    <option value="{{ $strategi->kode }}">{{ $strategi->nama }}</option>
                                @endforeach
                            </select>
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
                            <select name="indikator_kinerja" id="indikator_kinerja" class="form-control @error('indikator_kinerja') is-invalid @enderror" placeholder="Indikator Kinerja" value="{{ old('indikator_kinerja') }}" required>
                                <option value="">-- Pilih Indikator --</option>
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
                            <input type="text" class="form-control" id= "definisi" name="definisi" placeholder="Definisi" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Cara Perhitungan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="cara_perhitungan" name="cara_perhitungan" placeholder="Cara Perhitungan" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Satuan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Keterangan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Tahun*</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('indikator_kinerja') is-invalid @enderror" name="tahun" id="date-tahun"placeholder="Tahun" value="{{ old('tahun') }}" required>
                        </div>
                        {{-- @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Departemen*</label>
                        <div class="col-lg-10">
                            <select name="departemen" id="departemen" class="form-control @error('departemen') is-invalid @enderror" placeholder="Departemen" value="{{ old('departemen') }}" required>
                                    <option value="{{ $renstradept }}">{{ $dept[0] }}</option>
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
                            <input type="text" class="form-control" name="target" placeholder="Target" required>
                            @error('target')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group py-3">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus mr-2"></i> Tambah</button>
                        <a href="{{ route('renstra.dashboard') }}" id="back" class="btn btn-light"><i class="fa fa-times mr-2"></i> Batal</a>
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

    $('#indikator_kinerja').change(function(){
        $.ajax({
            url: '/renstra/indikators/' + $(this).val(),
            type: 'get',
            data: {},
            success: function(data) {
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

    $('#strategi').change(function(){
        // Empty the dropdown
        $('#indikator_kinerja').find('option').not(':first').remove();
        $.ajax({
            url: '/renstra/strategis/' + $(this).val(),
            type: 'get',
            dataType: 'json',
            data: {},
            success: function(response) {
                if(response['data'] != null){
                    len = response['data'].length;
                    for(var i=0; i<len; i++){

                        var id = response['data'][i].kode;
                        var name = response['data'][i].indikator_kinerja;

                        var option = new Option(name, id); 

                        $("#indikator_kinerja").append($(option)); 
                    }
                }
                else{
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
