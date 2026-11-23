@extends('layouts.admin')

@section('title', 'Data Departemen')

@section('content')
<div class="si-sheet">
    <div class="si-sheet-head">
        <div>
            <h2 class="si-sheet-title">Daftar Departemen</h2>
            <div class="small text-muted">Menambahkan departemen baru otomatis membuat akun Kepala &amp; Admin Departemen terkait.</div>
        </div>
        <a href="{{ route('departemen.create') }}" class="btn btn-sm btn-si-primary">
            <i class="fa-solid fa-plus me-1"></i> Tambah Departemen
        </a>
    </div>
    <div class="si-sheet-body">
        <div class="si-dept-grid">
            @foreach ($departemens as $departemen)
                <a href="{{ route('departemen.edit', $departemen->kode) }}" class="si-dept-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="si-pill si-pill-neutral si-mono">{{ $departemen->kode }}</span>
                        <span class="small text-muted"><i class="fa-solid fa-pen me-1"></i>Edit</span>
                    </div>
                    <div class="fw-bold" style="font-size: 1.02rem;">{{ $departemen->nama }}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
