@php
    $ribbonYear = $actConfig->tahun ?? null;
    $ribbonTw = (string) ($triwulan->triwulan ?? '0');
    $isPtnbh = Request::is('ptnbh*');
    $currentTrack = $isPtnbh ? 'ptnbh' : 'renstra';
    $deptCode = substr((string) ($user->kode ?? '00'), 0, 2);
@endphp

<div class="si-ribbon" aria-label="Status siklus kinerja">
    <div class="si-ribbon-steps">
        <span class="si-step {{ $ribbonYear ? 'is-done' : 'is-active' }}">
            <i class="fa-regular fa-calendar fa-fw"></i>
            Tahun {{ $ribbonYear ?: 'Belum Diatur' }}
        </span>

        @if ($ribbonYear)
            @php
                $targetDone = isset($jmlbelumdisetujui) ? ($jmlbelumdisetujui === 0 && ($jmltarget ?? 1) > 0) : ((int) $ribbonTw >= 1 || $ribbonTw === '0');
            @endphp
            <span class="si-step {{ $targetDone ? 'is-done' : 'is-active' }}">
                <i class="fa-solid {{ $targetDone ? 'fa-check' : 'fa-hourglass-half' }} fa-fw"></i>
                Target
            </span>

            @foreach (['1', '2', '3', '4'] as $q)
                @php
                    $isDoneQ = ($ribbonTw === '0') || ((int) $ribbonTw > (int) $q);
                    $isActiveQ = ($ribbonTw === $q);
                @endphp
                <span class="si-step {{ $isActiveQ ? 'is-active' : ($isDoneQ ? 'is-done' : '') }}">
                    @if ($isDoneQ)
                        <i class="fa-solid fa-check fa-fw"></i>
                    @elseif ($isActiveQ)
                        <i class="fa-solid fa-circle-dot fa-fw"></i>
                    @endif
                    TW {{ $q }}
                </span>
            @endforeach

            @if ($ribbonTw === '0')
                <span class="si-step is-done">
                    <i class="fa-solid fa-flag-checkered fa-fw"></i>
                    Periode Selesai
                </span>
            @endif
        @endif
    </div>

    <div class="si-track-switch" role="group" aria-label="Pilih track kinerja">
        <a href="{{ route('renstra.dashboard') }}" class="si-track-link {{ !$isPtnbh ? 'is-active' : '' }}">Renstra</a>
        <a href="{{ route('ptnbh.dashboard') }}" class="si-track-link {{ $isPtnbh ? 'is-active' : '' }}">PTN-BH</a>
    </div>
</div>
