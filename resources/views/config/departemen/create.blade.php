@extends('layouts.admin')

@section('title', 'Tambah Departemen')

@section('content')
<div class="si-sheet" style="max-width: 560px;">
    <div class="si-sheet-head">
        <h2 class="si-sheet-title">Tambah Departemen Baru</h2>
        <a href="{{ route('departemen.index') }}" class="btn btn-sm btn-si-outline">Kembali</a>
    </div>
    <div class="si-sheet-body">
        <form action="{{ route('departemen.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kode" class="form-label small fw-semibold">Kode Departemen (2 digit)*</label>
                <input id="kode" type="text" class="form-control si-mono @error('kode') is-invalid @enderror" name="kode" placeholder="Contoh: 07" value="{{ old('kode') }}" required>
                @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label small fw-semibold">Nama Departemen*</label>
                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Contoh: Bioteknologi" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-si-primary"><i class="fa-solid fa-plus me-1"></i> Tambah</button>
                <a href="{{ route('departemen.index') }}" class="btn btn-si-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
