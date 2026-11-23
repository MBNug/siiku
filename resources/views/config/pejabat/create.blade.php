@extends('layouts.admin')

@section('title', 'Tambah Pejabat')

@section('content')
<div class="si-sheet" style="max-width: 720px;">
    <div class="si-sheet-head">
        <h2 class="si-sheet-title">Tambah Pejabat Baru</h2>
        <a href="{{ route('pejabat.index') }}" class="btn btn-sm btn-si-outline">Kembali</a>
    </div>
    <div class="si-sheet-body">
        <form action="{{ route('pejabat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="departemen" class="form-label small fw-semibold">Unit / Departemen*</label>
                    <select name="departemen" id="departemen" class="form-select @error('departemen') is-invalid @enderror" required>
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->kode }}">{{ $departemen->nama }}</option>
                        @endforeach
                    </select>
                    @error('departemen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="jabatan" class="form-label small fw-semibold">Jabatan*</label>
                    <select name="jabatan" id="jabatan" class="form-select @error('jabatan') is-invalid @enderror" required>
                        <option value="">-- Pilih Jabatan --</option>
                    </select>
                    @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="nama" class="form-label small fw-semibold">Nama Lengkap &amp; Gelar*</label>
                    <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="nip" class="form-label small fw-semibold">NIP*</label>
                    <input id="nip" type="text" class="form-control si-mono @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" required>
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="tandatangan" class="form-label small fw-semibold">Gambar Tanda Tangan (.png, .jpg)*</label>
                    <input id="tandatangan" type="file" accept=".png,.jpg,.jpeg" class="form-control @error('tandatangan') is-invalid @enderror" name="tandatangan" required>
                    @error('tandatangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-si-primary"><i class="fa-solid fa-plus me-1"></i> Simpan Pejabat</button>
                <a href="{{ route('pejabat.index') }}" class="btn btn-si-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scriptlocal')
<script>
    $('#departemen').change(function () {
        $('#jabatan').find('option').not(':first').remove();
        const dept = $(this).val();
        if (dept === '00') {
            $('#jabatan').append(new Option('Dekan', '99'));
            $('#jabatan').append(new Option('Wakil Dekan 1', '98'));
            $('#jabatan').append(new Option('Wakil Dekan 2', '97'));
            $('#jabatan').append(new Option('Wakil Dekan 3', '96'));
            $('#jabatan').append(new Option('Wakil Dekan 4', '95'));
        } else if (dept) {
            $('#jabatan').append(new Option('Ketua Departemen', '01'));
        }
    });
</script>
@endsection
