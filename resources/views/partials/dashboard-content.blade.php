@php
    $trackLabel = $track === 'ptnbh' ? 'PTN-BH' : 'Renstra';
    $routePrefix = $track;
@endphp

@if (($err ?? 0) != 0 || empty($actConfig))
    <div class="si-sheet">
        <div class="si-sheet-body text-center py-5">
            <div class="mb-3" style="font-size: 2rem; color: var(--si-ink-muted);"><i class="fa-regular fa-calendar-xmark"></i></div>
            <h2 class="h5 fw-bold mb-2">Tahun Aktif Belum Diatur</h2>
            <p class="text-muted small mb-4">Atur tahun berjalan terlebih dahulu agar indikator, target, dan realisasi {{ $trackLabel }} dapat dipantau.</p>
            @if ($user->level == 1)
                <a href="{{ route('config.index') }}" class="btn btn-si-primary">Atur Tahun &amp; Indikator</a>
            @endif
        </div>
    </div>
@else
    @php
        $twVal = (string) ($triwulan->triwulan ?? '1');
        $indCount = (int) ($indikator ?? $jmlindikator ?? 0);
        $targetCount = (int) ($jmltarget ?? 0);
        $pendingTarget = (int) ($jmlbelumdisetujui ?? 0);
        $realisasiCount = (int) ($jmlrealisasi ?? 0);
        $tw1Count = (int) ($jmltriwulan1 ?? 0);
        $isFinished = ($twVal === '0');
        $showCheck = (int) ($check ?? 0);
    @endphp

    @if ($user->level < 2)
        <div class="si-kpi-grid">
            <div class="si-kpi-card">
                <div class="si-kpi-label">Tahun Aktif ({{ $trackLabel }})</div>
                <div class="si-kpi-val">{{ $actConfig->tahun }}</div>
                <div class="si-kpi-sub">{{ $isFinished ? 'Periode tahun selesai' : 'Triwulan ' . $twVal . ' berjalan' }}</div>
            </div>
            <div class="si-kpi-card">
                <div class="si-kpi-label">Indikator {{ $trackLabel }}</div>
                <div class="si-kpi-val">{{ (int) ($jmlindikator ?? $indCount) }}</div>
                <div class="si-kpi-sub">Per departemen aktif</div>
            </div>
            <div class="si-kpi-card">
                <div class="si-kpi-label">Status Target Departemen</div>
                <div class="si-kpi-val" style="color: {{ $pendingTarget > 0 ? 'var(--si-warn)' : 'var(--si-ok)' }};">
                    {{ $pendingTarget > 0 ? $pendingTarget . ' Pending' : 'Lengkap' }}
                </div>
                <div class="si-kpi-sub">{{ $targetCount > 0 ? $targetCount . ' total entri target' : 'Menunggu pembentukan target' }}</div>
            </div>
            <div class="si-kpi-card">
                <div class="si-kpi-label">Fase Aktivitas</div>
                <div class="fw-bold mt-2" style="font-size: 1rem;">
                    @if ($indCount == 0 && $realisasiCount == 0)
                        Pengaturan Indikator
                    @elseif ($targetCount == 0)
                        Pembentukan Target
                    @elseif ($pendingTarget != 0)
                        Persetujuan Target
                    @elseif ($tw1Count == 0 && $showCheck == 0)
                        Pembentukan Realisasi
                    @elseif ($isFinished && $showCheck == 1)
                        Periode Selesai
                    @else
                        Monitoring Realisasi TW {{ $twVal }}
                    @endif
                </div>
                <div class="si-kpi-sub">Tampilan Fakultas &amp; Pimpinan</div>
            </div>
        </div>

        @if ($pendingTarget == 0 && ($jmlindikator ?? 0) != 0)
            @if ($tw1Count == 0 && $showCheck == 0)
                <div class="si-sheet">
                    <div class="si-sheet-body text-center py-5">
                        <h2 class="h5 fw-bold mb-2">Data Realisasi Tahun {{ $actConfig->tahun }} Belum Dibentuk</h2>
                        <p class="text-muted small mb-4">Seluruh target telah disetujui. Buka menu Realisasi untuk membentuk lembar Triwulan 1 bagi tiap departemen.</p>
                        <a href="{{ route($routePrefix . '.realisasi.index') }}" class="btn btn-si-primary">Buka Realisasi {{ $trackLabel }}</a>
                    </div>
                </div>
            @else
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="si-sheet h-100">
                            <div class="si-sheet-head">
                                <h2 class="si-sheet-title">
                                    {{ $showCheck == 1 ? 'Ketercapaian IKU ' . $trackLabel . ' Tahun ' . $actConfig->tahun : 'Capaian per Departemen — Triwulan ' . $twVal }}
                                </h2>
                                @if ($showCheck == 0)
                                    <form action="{{ route($routePrefix . '.dashboard.filter') }}" method="GET" class="d-flex align-items-center gap-2">
                                        <select name="triwulan" class="form-select form-select-sm" style="width: auto;" aria-label="Pilih triwulan">
                                            @foreach (['1', '2', '3', '4'] as $optQ)
                                                <option value="{{ $optQ }}" {{ $twVal === $optQ ? 'selected' : '' }}>Triwulan {{ $optQ }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-si-outline">Terapkan</button>
                                    </form>
                                @endif
                            </div>
                            <div class="si-sheet-body">
                                <div style="height: 300px;">
                                    <canvas id="Chart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="si-sheet h-100">
                            <div class="si-sheet-head">
                                <h2 class="si-sheet-title">Rincian Status per Departemen</h2>
                                <a href="{{ route($routePrefix . '.target.index') }}" class="btn btn-sm btn-si-outline">Lihat Target {{ $actConfig->tahun }}</a>
                            </div>
                            <div class="table-responsive">
                                <table class="si-table">
                                    <thead>
                                        <tr>
                                            <th>Departemen</th>
                                            <th class="text-center">Melampaui</th>
                                            <th class="text-center">Tercapai</th>
                                            <th class="text-center">Tidak</th>
                                            <th class="text-center">Proses</th>
                                            <th class="text-center">Belum</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ketercapaiantargetdept as $satuan)
                                            <tr>
                                                <td class="fw-semibold">
                                                    <a href="{{ route($routePrefix . '.realisasidepartemen', [$satuan['kode'], $twVal]) }}" class="text-decoration-none" style="color: var(--si-accent);">
                                                        {{ $satuan['departemen'] }}
                                                    </a>
                                                </td>
                                                <td class="text-center si-num">{{ $satuan['0'] }}</td>
                                                <td class="text-center si-num">{{ $satuan['1'] }}</td>
                                                <td class="text-center si-num">{{ $satuan['2'] }}</td>
                                                <td class="text-center si-num">{{ $satuan['3'] }}</td>
                                                <td class="text-center si-num fw-semibold">{{ $satuan['4'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    (function () {
                        const ctx = document.getElementById('Chart1');
                        if (!ctx) return;
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: {{ Js::from($namadept) }},
                                datasets: [{
                                    label: 'Indikator Tercapai & Melampaui',
                                    data: {{ Js::from($ketercapaianpertriwulan) }},
                                    backgroundColor: '#1D4ED8',
                                    borderRadius: 4,
                                    maxBarThickness: 42
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        suggestedMax: {{ (int) ($jmlindikator ?? 5) }},
                                        ticks: { stepSize: 1, precision: 0 }
                                    }
                                }
                            }
                        });
                    })();
                </script>
            @endif
        @elseif ($indCount == 0 && $realisasiCount == 0)
            <div class="si-sheet">
                <div class="si-sheet-body text-center py-5">
                    <h2 class="h5 fw-bold mb-2">Indikator {{ $trackLabel }} Tahun {{ $actConfig->tahun }} Belum Diatur</h2>
                    <p class="text-muted small mb-4">Unggah master indikator melalui halaman Konfigurasi untuk memulai penetapan target.</p>
                    @if ($user->level == 1)
                        <a href="{{ route('config.index') }}" class="btn btn-si-primary">Atur Indikator Sekarang</a>
                    @endif
                </div>
            </div>
        @elseif ($targetCount == 0)
            <div class="si-sheet">
                <div class="si-sheet-body text-center py-5">
                    <h2 class="h5 fw-bold mb-2">Target {{ $trackLabel }} Tahun {{ $actConfig->tahun }} Belum Dibentuk</h2>
                    <p class="text-muted small mb-4">Pilih departemen untuk membentuk lembar target dari katalog indikator yang tersedia.</p>
                    @if ($user->level == 1)
                        <a href="{{ route($routePrefix . '.target.index') }}" class="btn btn-si-primary">Atur Target Departemen</a>
                    @endif
                </div>
            </div>
        @else
            <div class="si-sheet">
                <div class="si-sheet-head">
                    <h2 class="si-sheet-title">Progres Persetujuan Target per Departemen ({{ $actConfig->tahun }})</h2>
                    <a href="{{ route($routePrefix . '.target.index') }}" class="btn btn-sm btn-si-primary">Review Target</a>
                </div>
                <div class="si-sheet-body">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <div style="height: 300px;">
                                <canvas id="ChartApprovalOverview"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="table-responsive">
                                <table class="si-table">
                                    <thead>
                                        <tr>
                                            <th>Departemen</th>
                                            <th class="text-center">Disetujui</th>
                                            <th class="text-center">Pending</th>
                                            <th class="text-center">Ditolak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($namadepartemen as $idx => $dName)
                                            <tr>
                                                <td class="fw-semibold">{{ $dName }}</td>
                                                <td class="text-center si-num text-success">{{ $targetdisetujui[$idx] ?? 0 }}</td>
                                                <td class="text-center si-num text-warning">{{ $targetmenunggupersetujuan[$idx] ?? 0 }}</td>
                                                <td class="text-center si-num text-danger">{{ $targetditolak[$idx] ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                (function () {
                    const ctx = document.getElementById('ChartApprovalOverview');
                    if (!ctx) return;
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: {{ Js::from($namadepartemen) }},
                            datasets: [
                                { label: 'Disetujui', data: {{ Js::from($targetdisetujui) }}, backgroundColor: '#059669' },
                                { label: 'Menunggu', data: {{ Js::from($targetmenunggupersetujuan) }}, backgroundColor: '#D97706' },
                                { label: 'Ditolak', data: {{ Js::from($targetditolak) }}, backgroundColor: '#DC2626' }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: { stacked: true },
                                y: { stacked: true, beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
                            }
                        }
                    });
                })();
            </script>
        @endif
    @else
        {{-- Department View (Level 2) --}}
        <div class="si-kpi-grid">
            <div class="si-kpi-card">
                <div class="si-kpi-label">Tahun Aktif</div>
                <div class="si-kpi-val">{{ $actConfig->tahun }}</div>
                <div class="si-kpi-sub">Track {{ $trackLabel }}</div>
            </div>
            <div class="si-kpi-card">
                <div class="si-kpi-label">Periode Berjalan</div>
                <div class="si-kpi-val">{{ $isFinished ? 'Selesai' : 'TW ' . $twVal }}</div>
                <div class="si-kpi-sub">{{ $isFinished ? 'Pelaporan tahunan ditutup' : 'Triwulan aktif saat ini' }}</div>
            </div>
            <div class="si-kpi-card">
                <div class="si-kpi-label">Status Saat Ini</div>
                <div class="fw-bold mt-2" style="font-size: 1rem;">
                    @if ($indCount == 0 && $realisasiCount == 0)
                        Menunggu Pengaturan Indikator Fakultas
                    @elseif ($targetCount == 0)
                        Menunggu Pembentukan Target
                    @elseif ($pendingTarget != 0)
                        Revisi &amp; Persetujuan Target
                    @elseif ($tw1Count == 0 && $showCheck == 0 && $realisasiCount == 0)
                        Menunggu Aktivasi Realisasi
                    @elseif ($isFinished)
                        Periode Tahun {{ $actConfig->tahun }} Selesai
                    @else
                        Pengisian Realisasi Departemen
                    @endif
                </div>
            </div>
        </div>

        @if ($indCount == 0 && $realisasiCount == 0)
            <div class="si-sheet"><div class="si-sheet-body text-center py-5"><h2 class="h5 fw-bold mb-1">Indikator Tahun {{ $actConfig->tahun }} Belum Diatur</h2><p class="text-muted small mb-0">Hubungi Admin Fakultas untuk mengunggah indikator {{ $trackLabel }}.</p></div></div>
        @elseif ($targetCount == 0)
            <div class="si-sheet"><div class="si-sheet-body text-center py-5"><h2 class="h5 fw-bold mb-1">Target Tahun {{ $actConfig->tahun }} Belum Dibentuk</h2><p class="text-muted small mb-0">Menunggu Admin Fakultas membentuk lembar target departemen Anda.</p></div></div>
        @elseif ($pendingTarget != 0)
            <div class="si-sheet"><div class="si-sheet-body text-center py-5"><h2 class="h5 fw-bold mb-2">Target Tahun {{ $actConfig->tahun }} Sedang Diproses</h2><p class="text-muted small mb-3">Periksa status target atau lakukan perbaikan jika terdapat catatan penolakan.</p><a href="{{ route($routePrefix . '.targetdepartemen', $kode) }}" class="btn btn-si-primary">Lihat Target Departemen</a></div></div>
        @elseif ($tw1Count == 0 && $showCheck == 0 && $realisasiCount == 0)
            <div class="si-sheet"><div class="si-sheet-body text-center py-5"><h2 class="h5 fw-bold mb-1">Data Realisasi Sedang Disiapkan</h2><p class="text-muted small mb-0">Semua target sudah disetujui; menunggu inisiasi realisasi.</p></div></div>
        @elseif ($isFinished)
            <div class="si-sheet"><div class="si-sheet-body text-center py-5"><h2 class="h5 fw-bold mb-2">Pengisian Realisasi {{ $actConfig->tahun }} Selesai</h2><a href="{{ route($routePrefix . '.realisasidepartemen', [$kode, $twVal]) }}" class="btn btn-si-primary mt-2">Lihat Arsip Realisasi {{ $actConfig->tahun }}</a></div></div>
        @else
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="si-sheet h-100">
                        <div class="si-sheet-head">
                            <h2 class="si-sheet-title">Ketercapaian per Triwulan ({{ $actConfig->tahun }})</h2>
                            <a href="{{ route($routePrefix . '.realisasidepartemen', [$kode, $twVal]) }}" class="btn btn-sm btn-si-primary">Isi Realisasi TW {{ $twVal }}</a>
                        </div>
                        <div class="si-sheet-body">
                            <div style="height: 290px;"><canvas id="ChartDept"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="si-sheet h-100">
                        <div class="si-sheet-head"><h2 class="si-sheet-title">Rekap Capaian Triwulan 1–4</h2></div>
                        <div class="table-responsive">
                            <table class="si-table">
                                <thead>
                                    <tr>
                                        <th>Triwulan</th>
                                        <th class="text-center">Melampaui</th>
                                        <th class="text-center">Tercapai</th>
                                        <th class="text-center">Tidak</th>
                                        <th class="text-center">Proses</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ketercapaiantargetdept as $satuan)
                                        <tr>
                                            <td class="fw-semibold">
                                                <a href="{{ route($routePrefix . '.realisasidepartemen', [$kode, $satuan['triwulan']]) }}" class="text-decoration-none" style="color: var(--si-accent);">Triwulan {{ $satuan['triwulan'] }}</a>
                                            </td>
                                            <td class="text-center si-num">{{ $satuan['0'] }}</td>
                                            <td class="text-center si-num">{{ $satuan['1'] }}</td>
                                            <td class="text-center si-num">{{ $satuan['2'] }}</td>
                                            <td class="text-center si-num">{{ $satuan['3'] }}</td>
                                            <td class="text-center si-num fw-semibold">{{ $satuan['4'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                (function () {
                    const ctx = document.getElementById('ChartDept');
                    if (!ctx) return;
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: {{ Js::from($triwulanY) }}.map((q) => 'TW ' + q),
                            datasets: [{
                                label: 'Indikator Tercapai & Melampaui',
                                data: {{ Js::from($ketercapaianpertriwulan) }},
                                backgroundColor: '#1D4ED8',
                                borderRadius: 4,
                                maxBarThickness: 48
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true, suggestedMax: {{ (int) ($jmlindikator ?? 5) }}, ticks: { stepSize: 1, precision: 0 } }
                            }
                        }
                    });
                })();
            </script>
        @endif
    @endif
@endif
