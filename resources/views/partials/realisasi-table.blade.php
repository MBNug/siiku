@php
    $routePrefix = $track;
    $qStr = (string) $quarter;
    $activeTriStr = (string) ($actTri->triwulan ?? $triwulan->triwulan ?? '0');
    $showPrevQuarter = in_array($qStr, ['2', '3', '4'], true);
@endphp

<div class="si-sheet">
    <div class="si-sheet-head">
        <div class="si-quarter-tabs" role="tablist" aria-label="Pilih triwulan">
            @foreach (['1', '2', '3', '4'] as $qTab)
                <a href="{{ route($routePrefix . '.realisasidepartemen', [$deptKode, $qTab]) }}"
                   class="si-quarter-tab {{ $qStr === $qTab ? 'is-active' : '' }}">
                    Triwulan {{ $qTab }}
                </a>
            @endforeach
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route($routePrefix . '.realisasi.download', [$deptKode, $triwulan->triwulan]) }}" target="_blank" class="btn btn-sm btn-si-outline">
                <i class="fa-regular fa-file-pdf me-1"></i>
                Download PDF {{ $qStr === '0' ? 'Realisasi' : 'TW ' . $qStr }}
            </a>
            @if ($user->level != 2 && $qStr !== '0' && $activeTriStr === $qStr)
                <a href="{{ route($routePrefix . '.realisasi.alertakhiritriwulan', [$deptKode, $triwulan->triwulan]) }}" class="btn btn-sm btn-outline-danger">
                    <i class="fa-solid fa-lock me-1"></i> Akhiri Triwulan {{ $qStr }}
                </a>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="si-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th style="min-width: 260px;">Indikator &amp; Strategi</th>
                    <th>Satuan</th>
                    <th>Target</th>
                    @if ($showPrevQuarter)
                        <th>Status TW {{ (int) $qStr - 1 }}</th>
                    @endif
                    <th>Status {{ $qStr === '0' ? 'Realisasi' : 'TW ' . $qStr }}</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($realisasis as $realisasi)
                    <tr>
                        <td class="si-code fw-semibold">{{ $realisasi->kode }}</td>
                        <td>
                            <div class="fw-semibold">{{ $realisasi->indikator_kinerja }}</div>
                            <div class="small text-muted">{{ $realisasi->strategi }}</div>
                            <details class="mt-1 small">
                                <summary class="text-muted" style="cursor: pointer;">Definisi &amp; perhitungan</summary>
                                <div class="mt-1 p-2 rounded border" style="background: var(--si-sheet-muted); border-color: var(--si-border) !important;">
                                    <div><strong>Definisi:</strong> {{ $realisasi->definisi }}</div>
                                    <div class="mt-1"><strong>Perhitungan:</strong> {{ $realisasi->cara_perhitungan }}</div>
                                </div>
                            </details>
                        </td>
                        <td>
                            <div>{{ $realisasi->satuan }}</div>
                            <div class="small text-muted">{{ $realisasi->keterangan ?? '-' }}</div>
                        </td>
                        <td class="si-num fw-semibold">{{ $realisasi->target }}</td>
                        @if ($showPrevQuarter)
                            <td>
                                @include('partials.status-pill', ['status' => $realisasi->statusterakhir, 'kind' => 'realisasi'])
                            </td>
                        @endif
                        <td>
                            @include('partials.status-pill', ['status' => $realisasi->status, 'kind' => 'realisasi'])
                        </td>
                        <td>
                            @if ($realisasi->status != 'Belum Diupdate' && $realisasi->status != 'Sedang Diproses')
                                <a class="btn btn-sm btn-si-outline" href="{{ route($routePrefix . '.realisasi.show', [$deptKode, $triwulan->triwulan, $realisasi->kode]) }}">
                                    Lihat Data
                                </a>
                            @elseif ($user->level != 2 && $realisasi->status != 'Belum Diupdate')
                                <a class="btn btn-sm btn-si-primary" href="{{ route($routePrefix . '.realisasi.form', [$deptKode, $triwulan->triwulan, $realisasi->kode]) }}">
                                    Cek &amp; Nilai
                                </a>
                            @elseif ($user->level == 2 && ($realisasi->status === 'Belum Diupdate' || $realisasi->status === 'Sedang Diproses'))
                                <a class="btn btn-sm btn-si-primary" href="{{ route($routePrefix . '.realisasi.form', [$deptKode, $triwulan->triwulan, $realisasi->kode]) }}">
                                    Update Data
                                </a>
                            @else
                                <a class="btn btn-sm btn-si-outline" href="{{ route($routePrefix . '.realisasi.show', [$deptKode, $triwulan->triwulan, $realisasi->kode]) }}">
                                    Detail
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $showPrevQuarter ? 7 : 6 }}" class="text-center py-4 text-muted">
                            Belum ada data realisasi untuk triwulan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3 border-top" style="border-color: var(--si-border) !important;">
        {{ $realisasis->links('pagination.custom') }}
    </div>
</div>
