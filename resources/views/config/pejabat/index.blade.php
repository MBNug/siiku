@extends('layouts.admin')

@section('title', 'Data Pejabat Fakultas')

@section('content')
<div class="si-sheet">
    <div class="si-sheet-head">
        <div>
            <h2 class="si-sheet-title">Daftar Pejabat Penanda Tangan</h2>
            <div class="small text-muted">Digunakan pada pengesahan dokumen PDF Target dan Realisasi IKU.</div>
        </div>
        @if ($user->level == 1)
            <a href="{{ route('pejabat.create') }}" class="btn btn-sm btn-si-primary">
                <i class="fa-solid fa-plus me-1"></i> Tambah Pejabat
            </a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="si-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Unit / Departemen</th>
                    <th>Jabatan</th>
                    <th>Nama Pejabat</th>
                    <th>NIP</th>
                    @if ($user->level == 1)
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($pejabats as $pejabat)
                    <tr>
                        <td class="si-code fw-semibold">{{ $pejabat->kode }}</td>
                        <td>{{ $pejabat->departemen }}</td>
                        <td>{{ $pejabat->jabatan }}</td>
                        <td class="fw-semibold">{{ $pejabat->nama }}</td>
                        <td class="si-mono">{{ $pejabat->nip }}</td>
                        @if ($user->level == 1)
                            <td>
                                <a class="btn btn-sm btn-si-outline" href="{{ route('pejabat.edit', $pejabat->kode) }}">Edit</a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $user->level == 1 ? 6 : 5 }}" class="text-center py-4 text-muted">Belum ada data pejabat terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
