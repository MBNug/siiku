@php
    $routePrefix = $track;
@endphp

<div class="si-sheet">
    <div class="si-sheet-head">
        <div>
            <h2 class="si-sheet-title">{{ $title }}</h2>
            <div class="small text-muted si-mono">Kode Indikator: {{ $realisasi->kode }} · Triwulan {{ $triwulan->triwulan }}</div>
        </div>
        <a href="{{ route($routePrefix . '.realisasidepartemen', [$departemen->kode, $triwulan->triwulan]) }}" class="btn btn-sm btn-si-outline">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
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

        @if ($user->level != 2)
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="si-meta-label">Nilai Input Departemen</div>
                    <div class="si-num fs-5 fw-bold">{{ $realisasi->nilai ?? '-' }}</div>
                </div>
                <div class="col-md-8">
                    <div class="si-meta-label">Dokumen Bukti Terunggah</div>
                    @php $hasFiles = collect($files)->filter()->isNotEmpty(); @endphp
                    @if ($hasFiles)
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            @foreach ($files as $file)
                                @if ($file)
                                    <a href="{{ Storage::url($file) }}" target="_blank" class="btn btn-sm btn-si-outline">
                                        <i class="fa-regular fa-file me-1"></i> {{ basename($file) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="small text-muted">Belum ada berkas bukti yang diunggah.</div>
                    @endif
                </div>
            </div>

            <form action="{{ route($routePrefix . '.realisasi.simpan2', [$departemen->kode, $triwulan->triwulan, $realisasi->kode]) }}" method="POST" class="p-3 rounded border" style="background: var(--si-sheet-muted); border-color: var(--si-border) !important;">
                @csrf
                @method('PUT')
                <h3 class="h6 fw-bold mb-3">Penilaian Verifikator</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="status" class="form-label small fw-semibold">Status Ketercapaian*</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (['Tidak Tercapai', 'Tercapai', 'Melampaui Target'] as $opt)
                                <option value="{{ $opt }}" {{ old('status', $realisasi->status) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nilaireal" class="form-label small fw-semibold">Nilai Realisasi Disahkan*</label>
                        <input id="nilaireal" type="text" class="form-control si-num @error('nilaireal') is-invalid @enderror" name="nilaireal" placeholder="Masukkan angka realisasi" required value="{{ old('nilaireal', $realisasi->nilaireal ?? $realisasi->nilai) }}">
                        @error('nilaireal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-si-primary">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Penilaian
                    </button>
                    <a href="{{ route($routePrefix . '.realisasidepartemen', [$departemen->kode, $triwulan->triwulan]) }}" class="btn btn-si-outline">Batal</a>
                </div>
            </form>
        @else
            <form action="{{ route($routePrefix . '.realisasi.simpan', [$departemen->kode, $triwulan->triwulan, $realisasi->kode]) }}" method="POST" enctype="multipart/form-data" class="p-3 rounded border" style="background: var(--si-sheet-muted); border-color: var(--si-border) !important;">
                @csrf
                @method('PUT')
                <h3 class="h6 fw-bold mb-3">Pelaporan Realisasi Departemen</h3>
                <div class="mb-3" style="max-width: 360px;">
                    <label for="nilai" class="form-label small fw-semibold">Nilai Capaian*</label>
                    <input id="nilai" type="text" class="form-control si-num @error('nilai') is-invalid @enderror" name="nilai" placeholder="Contoh: 75" required value="{{ old('nilai', $realisasi->nilai) }}">
                    @error('nilai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Unggah Dokumen Bukti (opsional, maksimal 5 file)</label>
                    <input type="file" class="filepond" name="files" multiple data-allow-reorder="true" data-max-file-size="5MB" data-max-files="5">
                    <div class="form-text">Format diterima: PDF, JPG/PNG, DOC/DOCX, XLS/XLSX (maks. 5 MB per file).</div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-si-primary">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Kirim Realisasi
                    </button>
                    <a href="{{ route($routePrefix . '.realisasidepartemen', [$departemen->kode, $triwulan->triwulan]) }}" class="btn btn-si-outline">Batal</a>
                </div>
            </form>
        @endif
    </div>
</div>
