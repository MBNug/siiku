<div class="si-sheet">
    <div class="si-sheet-body text-center py-5">
        <div class="mb-3" style="font-size: 2rem; color: var(--si-ink-muted);">
            <i class="fa-regular fa-folder-open"></i>
        </div>
        <h2 class="h5 fw-bold mb-2">{{ $heading }}</h2>
        <p class="text-muted small mb-4">{{ $description }}</p>
        <a href="{{ $actionHref }}" class="btn btn-si-primary">
            <i class="fa-solid fa-plus me-1"></i> {{ $actionLabel }}
        </a>
    </div>
</div>
