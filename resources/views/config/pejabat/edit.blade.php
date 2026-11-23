@extends('layouts.admin')

@section('title', 'Edit Pejabat')

@section('content')
<div class="si-sheet" style="max-width: 720px;">
    <div class="si-sheet-head">
        <h2 class="si-sheet-title">Edit Data Pejabat ({{ $pejabat->kode }})</h2>
        <a href="{{ route('pejabat.index') }}" class="btn btn-sm btn-si-outline">Kembali</a>
    </div>
    <div class="si-sheet-body">
        <form action="{{ route('pejabat.update', $pejabat->kode) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="departemen" class="form-label small fw-semibold">Unit / Departemen</label>
                    <input type="text" class="form-control bg-light" name="departemen" id="departemen" value="{{ old('departemen', $pejabat->departemen) }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="jabatan" class="form-label small fw-semibold">Jabatan</label>
                    <input type="text" class="form-control bg-light" name="jabatan" id="jabatan" value="{{ old('jabatan', $pejabat->jabatan) }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="nama" class="form-label small fw-semibold">Nama Lengkap &amp; Gelar*</label>
                    <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $pejabat->nama) }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="nip" class="form-label small fw-semibold">NIP*</label>
                    <input id="nip" type="text" class="form-control si-mono @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $pejabat->nip) }}" required>
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="tandatangan" class="form-label small fw-semibold">Perbarui Tanda Tangan (opsional)</label>
                    <input id="tandatangan" type="file" accept=".png,.jpg,.jpeg" class="form-control @error('tandatangan') is-invalid @enderror" name="tandatangan">
                    @error('tandatangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-si-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
                <a href="{{ route('pejabat.index') }}" class="btn btn-si-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
