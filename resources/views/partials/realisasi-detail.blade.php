@php
    $routePrefix = $track;
@endphp

<div class="si-sheet">
    <div class="si-sheet-head">
        <div>
            <h2 class="si-sheet-title">{{ $title }}</h2>
            <div class="small text-muted si-mono">Kode Indikator: {{ $realisasi->kode }}</div>
        </div>
        <div class="d-flex gap-2">
            @if ($user->level != 2)
                <a class="btn btn-sm btn-si-primary" href="{{ route($routePrefix . '.realisasi.form', [$departemen->kode, $triwulan->triwulan, $realisasi->kode]) }}">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Nilai Realisasi
                </a>
            @endif
            <a href="{{ route($routePrefix . '.realisasidepartemen', [$departemen->kode, $triwulan->triwulan]) }}" class="btn btn-sm btn-si-outline">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="si-sheet-body">
        <div class="si-meta-grid mb-4">
            <div>
                <div class="si-meta-label">Indikator Kinerja</div>
                <div class="si-meta-val fw-semibold">{{ $realisasi->indikator_kinerja }}</div>
            </div>
            <div>
                <div class="si-meta-label">Strategi</div>
                <div class="si-meta-val">{{ $realisasi->strategi }}</div>
            </div>
            <div>
                <div class="si-meta-label">Target &amp; Satuan</div>
                <div class="si-meta-val si-num fw-semibold">{{ $realisasi->target }} {{ $realisasi->satuan }} ({{ $realisasi->keterangan ?? '-' }})</div>
            </div>
            <div>
                <div class="si-meta-label">Definisi</div>
                <div class="si-meta-val small">{{ $realisasi->definisi }}</div>
            </div>
            <div>
                <div class="si-meta-label">Cara Perhitungan</div>
                <div class="si-meta-val small">{{ $realisasi->cara_perhitungan }}</div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="si-meta-label">Nilai Input</div>
                <div class="si-num fs-5 fw-bold">{{ $realisasi->nilai ?? '-' }}</div>
            </div>
            <div class="col-md-3">
                <div class="si-meta-label">Nilai Realisasi Disahkan</div>
                <div class="si-num fs-5 fw-bold">{{ $realisasi->nilaireal ?? '-' }}</div>
            </div>
            <div class="col-md-3">
                <div class="si-meta-label">Status</div>
                <div class="mt-1">@include('partials.status-pill', ['status' => $realisasi->status, 'kind' => 'realisasi'])</div>
            </div>
            <div class="col-md-3">
                <div class="si-meta-label">Dokumen Bukti</div>
                @php $hasFiles = collect($files)->filter()->isNotEmpty(); @endphp
                @if ($hasFiles)
                    <div class="d-flex flex-column gap-1 mt-1">
                        @foreach ($files as $file)
                            @if ($file)
                                <a href="{{ Storage::url($file) }}" target="_blank" class="btn btn-sm btn-si-outline text-start">
                                    <i class="fa-regular fa-file me-1"></i> {{ basename($file) }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="small text-muted mt-1">Tidak ada berkas lampiran.</div>
                @endif
            </div>
        </div>
    </div>
</div>
