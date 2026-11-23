@extends('layouts.admin')

@section('title', 'Tahun & Indikator')

@section('csslocal')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="si-sheet h-100">
            <div class="si-sheet-head">
                <div>
                    <h2 class="si-sheet-title">Tahun Aktif Berjalan</h2>
                    <div class="small text-muted">Menentukan periode tahun pelaporan IKU yang aktif.</div>
                </div>
            </div>
            <div class="si-sheet-body">
                <form action="{{ route('config.settahun') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="date-tahun" class="form-label small fw-semibold">Pilih Tahun*</label>
                        <input type="text" class="form-control si-num @error('tahun') is-invalid @enderror" name="tahun" id="date-tahun" placeholder="YYYY"
                               value="{{ $countAct === 1 ? $actConfig[0]->tahun : old('tahun') }}" required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-si-primary">
                        <i class="fa-solid fa-check me-1"></i> Simpan Tahun Aktif
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="si-sheet h-100">
            <div class="si-sheet-head">
                <div>
                    <h2 class="si-sheet-title">Impor Katalog Indikator</h2>
                    <div class="small text-muted">Unggah file Excel/CSV untuk menambahkan indikator tahun berjalan.</div>
                </div>
            </div>
            <div class="si-sheet-body d-flex flex-column gap-4">
                <form action="{{ route('config.setindikator') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="indikator" class="form-label small fw-semibold">Indikator Renstra (.csv, .xls, .xlsx)*</label>
                    <div class="d-flex flex-wrap gap-2">
                        <input id="indikator" type="file" accept=".csv,.xls,.xlsx" class="form-control @error('indikator') is-invalid @enderror" name="indikator" style="max-width: 360px;" required>
                        <button type="submit" class="btn btn-si-outline">
                            <i class="fa-solid fa-file-arrow-up me-1"></i> Impor Renstra
                        </button>
                    </div>
                    @error('indikator')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </form>

                <hr class="my-0" style="border-color: var(--si-border);">

                <form action="{{ route('config.setindikatorptnbh') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="indikatorptnbh" class="form-label small fw-semibold">Indikator PTN-BH (.csv, .xls, .xlsx)*</label>
                    <div class="d-flex flex-wrap gap-2">
                        <input id="indikatorptnbh" type="file" accept=".csv,.xls,.xlsx" class="form-control @error('indikatorptnbh') is-invalid @enderror" name="indikatorptnbh" style="max-width: 360px;" required>
                        <button type="submit" class="btn btn-si-outline">
                            <i class="fa-solid fa-file-arrow-up me-1"></i> Impor PTN-BH
                        </button>
                    </div>
                    @error('indikatorptnbh')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
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
