<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') — SI-IKU Fakultas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;600&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/folio.css') }}" rel="stylesheet">
    @yield('csslocal')
</head>
<body>
@php
    $navTriwulan = ($triwulan->triwulan ?? null) ?: '1';
    $deptCode = substr((string) $user->kode, 0, 2);
    $roleLabel = match ((string) $user->level) {
        '0' => 'Dekan',
        '1' => 'Admin Fakultas',
        default => 'Departemen',
    };
    $initials = collect(explode(' ', trim($user->name ?? 'User')))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<div class="si-rail-backdrop" id="railBackdrop"></div>

<div class="si-shell">
    <aside class="si-rail" id="sideNav" aria-label="Navigasi utama">
        <div class="si-rail-brand">
            <a href="{{ route('renstra.dashboard') }}" class="si-brand-link">
                <svg width="30" height="30" viewBox="0 0 32 32" fill="none" aria-hidden="true">
                    <rect x="2" y="2" width="28" height="28" rx="6" fill="#1D4ED8"/>
                    <path d="M9 10H23M9 16H19M9 22H15" stroke="#FFFFFF" stroke-width="2.4" stroke-linecap="round"/>
                    <circle cx="22" cy="21" r="3" fill="#10B981"/>
                </svg>
                <span>
                    SI-IKU
                    <span class="si-brand-sub">Tata Kelola Kinerja Fakultas</span>
                </span>
            </a>
            <button type="button" class="btn btn-sm text-white d-lg-none" id="closeRailBtn" aria-label="Tutup menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="si-rail-nav">
            <div>
                <button class="si-nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#renstra-collapse" aria-expanded="{{ Request::is('renstra*') ? 'true' : 'false' }}">
                    <span>Track Renstra</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="collapse {{ Request::is('renstra*') ? 'show' : '' }}" id="renstra-collapse">
                    <ul class="si-nav-list">
                        <li>
                            <a href="{{ route('renstra.dashboard') }}" class="si-nav-link {{ Request::is('renstra/dashboard*') || Request::is('/') ? 'is-active' : '' }}">
                                <i class="fa-solid fa-chart-column fa-fw"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $user->level != 2 ? route('renstra.target.index') : route('renstra.targetdepartemen', $deptCode) }}" class="si-nav-link {{ Request::is('renstra/target*') ? 'is-active' : '' }}">
                                <i class="fa-solid fa-bullseye fa-fw"></i>
                                <span>Target</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $user->level != 2 ? route('renstra.realisasi.index') : route('renstra.realisasidepartemen', [$deptCode, $navTriwulan]) }}" class="si-nav-link {{ Request::is('renstra/*realisasi*') ? 'is-active' : '' }}">
                                <i class="fa-solid fa-clipboard-check fa-fw"></i>
                                <span>Realisasi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div>
                <button class="si-nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#ptnbh-collapse" aria-expanded="{{ Request::is('ptnbh*') ? 'true' : 'false' }}">
                    <span>Track PTN-BH</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="collapse {{ Request::is('ptnbh*') ? 'show' : '' }}" id="ptnbh-collapse">
                    <ul class="si-nav-list">
                        <li>
                            <a href="{{ route('ptnbh.dashboard') }}" class="si-nav-link {{ Request::is('ptnbh/dashboard*') ? 'is-active' : '' }}">
                                <i class="fa-solid fa-chart-line fa-fw"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $user->level != 2 ? route('ptnbh.target.index') : route('ptnbh.targetdepartemen', $deptCode) }}" class="si-nav-link {{ Request::is('ptnbh/target*') ? 'is-active' : '' }}">
                                <i class="fa-solid fa-bullseye fa-fw"></i>
                                <span>Target</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $user->level != 2 ? route('ptnbh.realisasi.index') : route('ptnbh.realisasidepartemen', [$deptCode, $navTriwulan]) }}" class="si-nav-link {{ Request::is('ptnbh/*realisasi*') ? 'is-active' : '' }}">
                                <i class="fa-solid fa-clipboard-check fa-fw"></i>
                                <span>Realisasi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            @if ($user->level == 1)
                <div>
                    <button class="si-nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#config-collapse" aria-expanded="{{ Request::is('config*') ? 'true' : 'false' }}">
                        <span>Konfigurasi</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="collapse {{ Request::is('config*') ? 'show' : '' }}" id="config-collapse">
                        <ul class="si-nav-list">
                            <li>
                                <a href="{{ route('config.index') }}" class="si-nav-link {{ Request::is('config/tahun*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-calendar-check fa-fw"></i>
                                    <span>Tahun &amp; Indikator</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pejabat.index') }}" class="si-nav-link {{ Request::is('config/pejabat*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-user-tie fa-fw"></i>
                                    <span>Pejabat</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('departemen.index') }}" class="si-nav-link {{ Request::is('config/departemen*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-building-columns fa-fw"></i>
                                    <span>Departemen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </nav>

        <div class="si-rail-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="si-logout-btn">
                    <i class="fa-solid fa-right-from-bracket fa-fw"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="si-main">
        <header class="si-topbar">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-si-outline btn-sm d-lg-none" id="openRailBtn" aria-label="Buka menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="si-page-title">@yield('title', 'Dashboard')</h1>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if (config('app.demo_mode'))
                    <span class="si-pill si-pill-warn d-none d-sm-inline-flex">Mode Demo</span>
                @endif
                <a href="{{ route('user.gantipassword') }}" class="si-user-chip" title="Pengaturan akun &amp; password">
                    <span class="si-avatar">{{ $initials ?: 'U' }}</span>
                    <span class="d-none d-md-inline">{{ $user->name }}</span>
                    <span class="si-role-badge d-none d-sm-inline">{{ $roleLabel }}</span>
                </a>
            </div>
        </header>

        @include('partials.rollover-ribbon')

        <main class="si-workspace">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <strong><i class="fa-solid fa-triangle-exclamation me-2"></i>Periksa kembali input Anda:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('assets/jquery.js') }}"></script>
<script src="{{ asset('assets/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/bootstrap.js') }}"></script>
@if (!Session::has('alert.config') && !Session::has('alert.delete'))
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endif
@include('sweetalert::alert')

<script>
(function () {
    const rail = document.getElementById('sideNav');
    const backdrop = document.getElementById('railBackdrop');
    const openBtn = document.getElementById('openRailBtn');
    const closeBtn = document.getElementById('closeRailBtn');

    function setOpen(open) {
        if (!rail || !backdrop) return;
        rail.classList.toggle('is-open', open);
        backdrop.classList.toggle('is-open', open);
    }

    if (openBtn) openBtn.addEventListener('click', () => setOpen(true));
    if (closeBtn) closeBtn.addEventListener('click', () => setOpen(false));
    if (backdrop) backdrop.addEventListener('click', () => setOpen(false));

    document.addEventListener('submit', function (e) {
        const form = e.target.closest('.js-confirm-action');
        if (!form || form.dataset.confirmed === '1') return;
        e.preventDefault();

        const title = form.dataset.title || 'Konfirmasi tindakan';
        const text = form.dataset.text || 'Tindakan ini akan langsung diproses.';
        const confirmText = form.dataset.confirm || 'Ya, lanjutkan';

        if (typeof Swal === 'undefined') {
            if (window.confirm(title + '\n\n' + text)) {
                form.dataset.confirmed = '1';
                form.submit();
            }
            return;
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b91c1c',
            cancelButtonColor: '#525e71',
            confirmButtonText: confirmText,
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function (result) {
            if (result.isConfirmed) {
                form.dataset.confirmed = '1';
                form.submit();
            }
        });
    });
})();
</script>

@yield('scriptlocal')
</body>
</html>
