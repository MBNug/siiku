@extends('layouts.admin')
{{-- @dd($actConfig) --}}

@section('title', 'Atur Config Berjalan')

@section('csslocal')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-9">
                    <h1 class="h5 mx-3 mb-2 text-primary">Atur Tahun Berjalan</h1>
                </div>
            </div>
            <div class="container mt-3 mb-2">
                <form action="{{ route('config.settahun') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Tahun*</label>
                        <div class="col-lg-4">
                            {{-- <input type="hidden" name="_method" value="PUT"> --}}
                            <input type="text" class="form-control @error('tahun') is-invalid @enderror" name="tahun" id="date-tahun"placeholder="Tahun"  
                            @if ($countAct === 1)
                                value= "{{ $actConfig[0]->tahun }}"
                            @else
                                value = "{{ old('tahun') }}"
                            @endif 
                            required>
                            @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-2"></div> {{-- padding --}}
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus mr-2"></i>Set Tahun</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <h1 class="h5 mx-3 mb-2 text-primary">Atur Indikator</h1>
                </div>
            </div>
            <div class="container mt-3 mb-2">
                <form action="{{ route('config.setindikator') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label py-3">Indikator*</label>
                        <div class="col-lg-4">
                            <input type="file" accept=".csv,.xls,.xlsx" class="form-control @error('indikator') is-invalid @enderror" name="indikator" placeholder="Indikator" value="{{ old('indikator') }}" required>
                        </div>
                        <div class="col-lg-2"></div> {{-- padding --}}
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus mr-2"></i>Set Indikator</button>
                        </div>
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
@endsection