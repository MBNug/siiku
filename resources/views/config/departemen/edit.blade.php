@extends('layouts.admin')

@section('title', 'Edit Departemen')

@section('content')
<div class="si-sheet" style="max-width: 560px;">
    <div class="si-sheet-head">
        <h2 class="si-sheet-title">Edit Departemen ({{ $departeman->kode }})</h2>
        <a href="{{ route('departemen.index') }}" class="btn btn-sm btn-si-outline">Kembali</a>
    </div>
    <div class="si-sheet-body">
        <form action="{{ route('departemen.update', $departeman->kode) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="kode" class="form-label small fw-semibold">Kode Departemen*</label>
                <input id="kode" type="text" class="form-control si-mono @error('kode') is-invalid @enderror" name="kode" value="{{ old('kode', $departeman->kode) }}" required>
                @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label small fw-semibold">Nama Departemen*</label>
                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $departeman->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-si-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan</button>
                <a href="{{ route('departemen.index') }}" class="btn btn-si-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
