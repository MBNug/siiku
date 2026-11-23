@php
    $statusVal = (string) ($status ?? '');
    $kind = $kind ?? 'realisasi';

    if ($kind === 'target') {
        [$pillClass, $pillText] = match ($statusVal) {
            '1' => ['si-pill-ok', 'Disetujui'],
            '2' => ['si-pill-accent', 'Menunggu Persetujuan'],
            '3' => ['si-pill-danger', 'Ditolak'],
            '4' => ['si-pill-warn', 'Sedang Diedit'],
            default => ['si-pill-neutral', 'Belum Diisi'],
        };
    } else {
        [$pillClass, $pillText] = match ($statusVal) {
            'Melampaui Target' => ['si-pill-accent', 'Melampaui Target'],
            'Tercapai' => ['si-pill-ok', 'Tercapai'],
            'Tidak Tercapai' => ['si-pill-danger', 'Tidak Tercapai'],
            'Sedang Diproses' => ['si-pill-warn', 'Menunggu Penilaian'],
            default => ['si-pill-neutral', 'Belum Diupdate'],
        };
    }
@endphp

<span class="si-pill {{ $pillClass }}">{{ $pillText }}</span>
