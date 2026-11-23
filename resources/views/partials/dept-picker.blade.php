<div class="si-sheet">
    <div class="si-sheet-head">
        <div>
            <h2 class="si-sheet-title">{{ $heading }}</h2>
            <div class="small text-muted">{{ $subtitle }}</div>
        </div>
    </div>
    <div class="si-sheet-body">
        <div class="si-dept-grid">
            @foreach ($departemens as $departemen)
                @php
                    $href = $mode === 'realisasi'
                        ? route($track . '.realisasidepartemen', [$departemen->kode, ($triwulan->triwulan ?? '1')])
                        : route($track . '.targetdepartemen', $departemen->kode);
                @endphp
                <a href="{{ $href }}" class="si-dept-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="si-pill si-pill-neutral si-mono">{{ $departemen->kode }}</span>
                        <i class="fa-solid fa-arrow-right text-muted small"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size: 1.02rem;">Departemen {{ $departemen->nama }}</div>
                        <div class="small text-muted mt-1">{{ $actionLabel }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
