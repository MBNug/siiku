@php
    $routePrefix = $track;
@endphp

<div class="si-sheet">
    <div class="si-sheet-head">
        <div>
            <h2 class="si-sheet-title">{{ $title }}</h2>
            <div class="small text-muted">Kelola dan verifikasi usulan target indikator kinerja departemen.</div>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route($routePrefix . '.target.download', $deptKode) }}" target="_blank" class="btn btn-sm btn-si-outline">
                <i class="fa-regular fa-file-pdf me-1"></i> Download PDF Target
            </a>
            @if ($user->level == 0 && $status === 2)
                <form action="{{ route($routePrefix . '.target.AllAprove', $deptKode) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-si-primary">
                        <i class="fa-solid fa-check-double me-1"></i> Setujui Semua Pending
                    </button>
                </form>
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
                    <th>Status</th>
                    @if ($user->level != 2)
                        <th style="min-width: 170px;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($targets as $target)
                    @php
                        $rowClass = match ((string) $target->status) {
                            '3' => 'is-row-rejected',
                            '4' => 'is-row-editing',
                            default => '',
                        };
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td class="si-code fw-semibold">{{ $target->kode }}</td>
                        <td>
                            <div class="fw-semibold">{{ $target->indikator_kinerja }}</div>
                            <div class="small text-muted">{{ $target->strategi }}</div>
                            <details class="mt-1 small">
                                <summary class="text-muted" style="cursor: pointer;">Definisi &amp; perhitungan</summary>
                                <div class="mt-1 p-2 rounded border" style="background: var(--si-sheet-muted); border-color: var(--si-border) !important;">
                                    <div><strong>Definisi:</strong> {{ $target->definisi }}</div>
                                    <div class="mt-1"><strong>Perhitungan:</strong> {{ $target->cara_perhitungan }}</div>
                                </div>
                            </details>
                        </td>
                        <td>
                            <div>{{ $target->satuan }}</div>
                            <div class="small text-muted">{{ $target->keterangan ?? '-' }}</div>
                        </td>
                        <td>
                            @if ($user->level != 2 && ((string) $target->status === '0' || (string) $target->status === '4'))
                                <form id="target-update-{{ $target->kode }}" action="{{ route($routePrefix . '.target.kirim', $target->kode) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" class="form-control form-control-sm si-num" name="target" value="{{ old('target', $target->target) }}" style="width: 96px;" aria-label="Nilai target {{ $target->kode }}">
                                </form>
                            @else
                                <span class="si-num fw-semibold">{{ $target->target ?? 'Belum diatur' }}</span>
                            @endif
                        </td>
                        <td>
                            @include('partials.status-pill', ['status' => $target->status, 'kind' => 'target'])
                        </td>
                        @if ($user->level != 2)
                            <td>
                                @if ((string) $target->status === '0' || (string) $target->status === '4')
                                    <div class="d-flex flex-wrap gap-1">
                                        <button type="submit" form="target-update-{{ $target->kode }}" class="btn btn-sm btn-si-primary">Kirim</button>
                                        @if ($user->level == 0 && (string) $target->status === '4')
                                            <button type="submit" form="batal-form-{{ $target->kode }}" class="btn btn-sm btn-si-outline">Batal</button>
                                        @endif
                                    </div>
                                @elseif ($user->level == 0)
                                    @if ((string) $target->status === '1')
                                        <div class="si-danger-isolate mt-0 pt-0 border-0">
                                            <form action="{{ route($routePrefix . '.target.batal', $target->kode) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">Batalkan Persetujuan</button>
                                            </form>
                                        </div>
                                    @elseif ((string) $target->status === '2')
                                        <div class="d-flex flex-column gap-1">
                                            <form action="{{ route($routePrefix . '.target.setujui', $target->kode) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-si-primary w-100">Setujui</button>
                                            </form>
                                            <a class="btn btn-sm btn-si-outline w-100" href="{{ route($routePrefix . '.target.edit', $target->kode) }}">Edit Nilai</a>
                                            <div class="si-danger-isolate">
                                                <form action="{{ route($routePrefix . '.target.tolak', $target->kode) }}" method="POST" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">Tolak</button>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif ((string) $target->status === '3')
                                        <div class="d-flex flex-column gap-1">
                                            <form action="{{ route($routePrefix . '.target.setujui', $target->kode) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-si-primary w-100">Setujui</button>
                                            </form>
                                            <a class="btn btn-sm btn-si-outline w-100" href="{{ route($routePrefix . '.target.edit', $target->kode) }}">Edit Nilai</a>
                                        </div>
                                    @endif
                                @else
                                    @if ((string) $target->status === '3')
                                        <a class="btn btn-sm btn-si-outline" href="{{ route($routePrefix . '.target.edit', $target->kode) }}">Edit Nilai</a>
                                    @else
                                        <span class="small text-muted">—</span>
                                    @endif
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3 border-top" style="border-color: var(--si-border) !important;">
        {{ $targets->links('pagination.custom') }}
    </div>
</div>

@if ($user->level == 0)
    @foreach ($targets as $target)
        @if ((string) $target->status === '4')
            <form id="batal-form-{{ $target->kode }}" action="{{ route($routePrefix . '.target.batal', $target->kode) }}" method="POST" class="d-none">
                @csrf
            </form>
        @endif
    @endforeach
@endif
