@extends('layouts.admin')

@section('title', 'Ganti Password')

@section('content')
<div class="si-sheet" style="max-width: 520px;">
    <div class="si-sheet-head">
        <h2 class="si-sheet-title">Pengaturan Keamanan Akun</h2>
        <a href="{{ route('renstra.dashboard') }}" class="btn btn-sm btn-si-outline">Kembali</a>
    </div>
    <div class="si-sheet-body">
        @if (config('app.demo_mode'))
            <div class="alert alert-warning small mb-3">
                <strong>Mode Demo Aktif:</strong> Pengubahan password dinonaktifkan agar akun demo tetap dapat diakses pengunjung lainnya.
            </div>
        @endif

        <form action="{{ route('user.updatePassword') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="passwordlama" class="form-label small fw-semibold">Password Lama*</label>
                <input id="passwordlama" type="password" class="form-control @error('passwordlama') is-invalid @enderror" name="passwordlama" value="{{ old('passwordlama') }}" {{ config('app.demo_mode') ? 'disabled' : 'required' }}>
                @error('passwordlama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="passwordbaru" class="form-label small fw-semibold">Password Baru*</label>
                <input id="passwordbaru" type="password" class="form-control @error('passwordbaru') is-invalid @enderror" name="passwordbaru" value="{{ old('passwordbaru') }}" {{ config('app.demo_mode') ? 'disabled' : 'required' }}>
                @error('passwordbaru')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="konfirmasipassword" class="form-label small fw-semibold">Konfirmasi Password Baru*</label>
                <input id="konfirmasipassword" type="password" class="form-control @error('konfirmasipassword') is-invalid @enderror" name="konfirmasipassword" value="{{ old('konfirmasipassword') }}" {{ config('app.demo_mode') ? 'disabled' : 'required' }}>
                @error('konfirmasipassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-si-primary" {{ config('app.demo_mode') ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Password
                </button>
                <a href="{{ route('renstra.dashboard') }}" class="btn btn-si-outline">Kembali ke Dashboard</a>
            </div>
        </form>
    </div>
</div>
@endsection
